<?php

namespace App\Http\Livewire\Admin;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Hombrevivo;
use App\Models\Intervalo;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HombreVivoExport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ListadoHv extends Component
{
    use AuthorizesRequests;
    public $cliente_id = '';
    public $empleado_id = '';
    public $fecha_inicio;
    public $fecha_fin;
    public $clientes = [];
    public $empleados = [];
    public $resultados = [];
    public $mostrarResultados = false;

    public function mount()
    {
        $this->authorize('admin.hombre_vivo');
        Carbon::setLocale('es');

        $this->clientes = Cliente::where('status', 1)
            ->orderBy('nombre')
            ->get();

        $this->fecha_inicio = Carbon::now()->subDays(6)->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->format('Y-m-d');
    }

    public function updatedClienteId()
    {
        if ($this->cliente_id) {
            $this->empleados = Empleado::whereHas('designaciones', function ($query) {
                $query->whereHas('turno', function ($subQuery) {
                    $subQuery->where('cliente_id', $this->cliente_id);
                })->where('estado', true);
            })->orderBy('nombres')->get();
        } else {
            $this->empleados = [];
        }
        $this->empleado_id = '';
    }

    public function generarReporte()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $this->resultados = [];
        $this->mostrarResultados = true;

        $query = Hombrevivo::join('intervalos', 'hombrevivos.intervalo_id', '=', 'intervalos.id')
            ->join('designaciones', 'intervalos.designacione_id', '=', 'designaciones.id')
            ->join('turnos', 'designaciones.turno_id', '=', 'turnos.id')
            ->whereBetween('hombrevivos.fecha', [$this->fecha_inicio, $this->fecha_fin])
            ->where('hombrevivos.status', true);

        if ($this->cliente_id) {
            $query->where('turnos.cliente_id', $this->cliente_id);
        }

        if ($this->empleado_id) {
            $query->where('designaciones.empleado_id', $this->empleado_id);
        }

        $marcaciones = $query->select('hombrevivos.*', 'designaciones.empleado_id')->get();

        $fechaInicio = Carbon::parse($this->fecha_inicio);
        $fechaFin = Carbon::parse($this->fecha_fin);

        if (!$this->empleado_id) {
            $empleadosQuery = Empleado::whereHas('designaciones', function ($query) use ($fechaInicio, $fechaFin) {
                $q = $query->where('estado', true);

                if ($this->cliente_id) {
                    $q->whereHas('turno', function ($subQuery) {
                        $subQuery->where('cliente_id', $this->cliente_id);
                    });
                }

                $q->where('fechaInicio', '<=', $fechaFin->format('Y-m-d'))
                    ->where('fechaFin', '>=', $fechaInicio->format('Y-m-d'));
            });
            $empleadosIds = $empleadosQuery->pluck('id');
        } else {
            $empleadosIds = collect([$this->empleado_id]);
        }

        foreach ($empleadosIds as $empId) {
            $empleado = Empleado::find($empId);
            if (!$empleado) continue;

            $datosEmpleado = [
                'empleado_id' => $empId,
                'empleado_nombre' => $empleado->nombres . ' ' . $empleado->apellidos,
                'total_marcaciones' => 0,
                'dias' => []
            ];

            $fechaActual = $fechaInicio->copy();
            $tieneDatos = false;

            while ($fechaActual <= $fechaFin) {
                $fechaStr = $fechaActual->format('Y-m-d');

                $cantidadDia = $marcaciones->where('empleado_id', $empId)
                    ->where('fecha', $fechaStr)
                    ->count();

                $intervalosEsperados = Intervalo::whereHas('designacione', function ($q) use ($empId, $fechaStr) {
                    $q->where('empleado_id', $empId)
                        ->where('fechaInicio', '<=', $fechaStr)
                        ->where('fechaFin', '>=', $fechaStr)
                        ->where('estado', true);
                })->count();

                if ($intervalosEsperados > 0 || $cantidadDia > 0) {
                    $tieneDatos = true;
                }

                $datosEmpleado['dias'][] = [
                    'fecha' => $fechaStr,
                    'cantidad' => $cantidadDia,
                    'esperadas' => $intervalosEsperados,
                    'cumplimiento' => $intervalosEsperados > 0
                        ? round(($cantidadDia / $intervalosEsperados) * 100, 1)
                        : 0
                ];

                $datosEmpleado['total_marcaciones'] += $cantidadDia;
                $fechaActual->addDay();
            }

            if ($tieneDatos) {
                $this->resultados[] = $datosEmpleado;
            }
        }
    }

    public function limpiar()
    {
        $this->cliente_id = '';
        $this->empleado_id = '';
        $this->fecha_inicio = Carbon::now()->subDays(6)->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->format('Y-m-d');
        $this->resultados = [];
        $this->empleados = [];
        $this->mostrarResultados = false;
    }

    public function exportarExcel()
    {
        if (empty($this->resultados)) {
            session()->flash('warning', 'No hay datos para exportar.');
            return;
        }

        $nombreCliente = $this->cliente_id
            ? Cliente::find($this->cliente_id)->nombre
            : 'Todos';

        $filename = 'reporte_hombre_vivo_' . str_replace(' ', '_', $nombreCliente) . '_' . date('Y-m-d') . '.xlsx';

        return Excel::download(
            new HombreVivoExport($this->resultados, $this->fecha_inicio, $this->fecha_fin),
            $filename
        );
    }

    public function exportarPdf()
    {
        if (empty($this->resultados)) {
            session()->flash('warning', 'No hay datos para exportar.');
            return;
        }

        Carbon::setLocale('es');
        $fechaI = Carbon::parse($this->fecha_inicio);
        $fechaF = Carbon::parse($this->fecha_fin);
        $dias = [];
        $current = $fechaI->copy();

        while ($current <= $fechaF) {
            $dias[] = [
                'fecha' => $current->format('Y-m-d'),
                'dia' => $current->format('d'),
                'mes' => mb_substr($current->translatedFormat('M'), 0, 3),
                'diaNombre' => mb_substr($current->translatedFormat('l'), 0, 3)
            ];
            $current->addDay();
        }

        $nombreCliente = $this->cliente_id
            ? Cliente::find($this->cliente_id)->nombre
            : 'Todos los clientes';

        $pdf = PDF::loadView('reports.hombre-vivo-pdf', [
            'resultados' => $this->resultados,
            'dias' => $dias,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'cliente' => $nombreCliente,
            'fecha_reporte' => Carbon::now()->format('d/m/Y H:i')
        ])->setPaper('a4', 'landscape');

        $filename = 'reporte_hombre_vivo_' . date('Y-m-d_His') . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $filename);
    }

    public function render()
    {
        return view('livewire.admin.listado-hv')->extends('adminlte::page');
    }
}
