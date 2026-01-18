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
use Carbon\CarbonPeriod;
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


        $resultados = array();
        foreach ($empleadosIds as $empId) {
            $designaciones = traeTodasDesignaciones($empId, $fechaInicio->format('Y-m-d'), $fechaFin->format('Y-m-d'));
            foreach ($designaciones as $desig) {
                $turno = $desig->turno;
                $intervalos = $desig->intervalos->pluck('id')->toArray();
                $resultado = [
                    'empleado_nombre' => $desig->empleado->nombres . ' ' . $desig->empleado->apellidos,
                    'total_marcaciones' => 0,
                    'dias' => []
                ];

                foreach (CarbonPeriod::create($fechaInicio, $fechaFin) as $fecha) {
                    $fechaActual = $fecha->format('Y-m-d');
                    $horainicio = Carbon::parse($turno->horainicio)->subMinutes(15)->format('H:i:s');
                    $horafin = Carbon::parse($turno->horafin)->addMinutes(30)->format('H:i:s');
                    $registros = collect();
                    if (Carbon::parse($turno->horainicio)->gt(Carbon::parse($turno->horafin))) {
                        // NOCTURNO
                        $fechaBase = $fecha->copy();

                        $registros = Hombrevivo::whereIn('intervalo_id', $intervalos)
                            ->where(function ($q) use ($fechaBase, $horainicio, $horafin, $fechaActual) {
                                $q->where(function ($q1) use ($fechaActual, $horainicio) {
                                    $q1->whereDate('fecha', $fechaActual)
                                        ->where('hora', '>=', $horainicio);
                                })
                                ->orWhere(function ($q2) use ($fechaBase, $horafin) {
                                    $q2->whereDate('fecha', $fechaBase->copy()->addDay()->format('Y-m-d'))
                                        ->where('hora', '<=', $horafin);
                                });
                            })
                            ->get();
                    } else {
                        $registros = Hombrevivo::whereDate('fecha', $fechaActual)
                            ->whereIn('intervalo_id', $intervalos)
                            ->whereBetween('hora', [$horainicio, $horafin])
                            ->get();
                    }

                    // lista detallada de marcaciones (fecha y hora) para este día
                    $marcacionesList = $registros->map(function ($r) {
                        $fecha = \Carbon\Carbon::parse($r->fecha)->format('Y-m-d');
                        $hora = isset($r->hora) && $r->hora ? $r->hora : \Carbon\Carbon::parse($r->fecha)->format('H:i:s');
                        return $fecha . ' ' . $hora;
                    })->values()->all();

                    $cantReg = $registros->count();
                    $esperadas = count($intervalos);
                    $cumpl = $esperadas > 0 ? round(($cantReg / $esperadas) * 100, 1) : 0;

                    $resultado['dias'][] = [
                        'fecha' => $fechaActual,
                        'hora_inicio' => $horainicio,
                        'hora_fin' => $horafin,
                        'cant_registros' => $cantReg,
                        'esperadas' => $esperadas,
                        'cumplimiento' => $cumpl,
                        'marcaciones' => $marcacionesList,
                    ];

                    $resultado['total_marcaciones'] += $cantReg;
                }

                $resultados[] = $resultado;
            }
        }
        $this->resultados = $resultados;
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

        $nombreClienteFiltro = $this->cliente_id ? (Cliente::find($this->cliente_id)->nombre ?? 'N/A') : 'Todos';
        if ($this->empleado_id) {
            $empObj = Empleado::find($this->empleado_id);
            $nombreEmpleadoFiltro = $empObj ? ($empObj->nombres . ' ' . $empObj->apellidos) : 'N/A';
        } else {
            $nombreEmpleadoFiltro = 'Todos';
        }

        $filters = [
            'cliente' => $nombreClienteFiltro,
            'empleado' => $nombreEmpleadoFiltro,
        ];

        return Excel::download(
            new HombreVivoExport($this->resultados, $this->fecha_inicio, $this->fecha_fin, $filters),
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
            ? (Cliente::find($this->cliente_id)->nombre ?? 'Todos los clientes')
            : 'Todos los clientes';

        $nombreEmpleado = $this->empleado_id
            ? (Empleado::find($this->empleado_id) ? (Empleado::find($this->empleado_id)->nombres . ' ' . Empleado::find($this->empleado_id)->apellidos) : 'N/A')
            : 'Todos los empleados';

        $pdf = PDF::loadView('reports.hombre-vivo-pdf', [
            'resultados' => $this->resultados,
            'dias' => $dias,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'cliente' => $nombreCliente,
            'empleado' => $nombreEmpleado,
            'fecha_reporte' => Carbon::now()->format('d/m/Y H:i')
        ])->setPaper('a4', 'landscape');

        $filename = 'reporte_hombre_vivo_' . str_replace(' ', '_', $nombreCliente) . '_' . date('Y-m-d_His') . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $filename);
    }

    public function render()
    {
        return view('livewire.admin.listado-hv')->extends('adminlte::page');
    }
}
