<?php

namespace App\Http\Livewire\Admin;

use App\Models\Cliente;
use App\Models\Designaciondia;
use App\Models\Designacione;
use App\Models\Empleado;
use App\Models\Intervalo;
use App\Models\Rrhhcontrato;
use App\Models\Turno;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NuevaDesignacion extends Component
{
    public $designacione = null;
    public $empleadoid = "", $empleado = null, $nombres = "",  $clienteid = "", $clienteSeleccionado = null;
    public $turnoid = "", $fechaInicio = "", $fechaFin = "", $intervalo_hv = 0, $observaciones = "";
    public $lunes = false, $martes = false, $miercoles = false, $jueves = false, $viernes = false, $sabado = false, $domingo = false;
    public $contrato = NULL;

    protected $rules = [
        'empleadoid' => 'required',
        'clienteid' => 'required',
        'turnoid' => 'required',
        'fechaInicio' => 'required',
        'fechaFin' => 'required',
    ];

    public function seleccionarTodosDias()
    {
        $this->lunes = true;
        $this->martes = true;
        $this->miercoles = true;
        $this->jueves = true;
        $this->viernes = true;
        $this->sabado = true;
        $this->domingo = true;
    }

    public function updatedFechaInicio()
    {
        if (
            $this->fechaInicio >= $this->contrato->fecha_inicio
            && (is_null($this->contrato->fecha_fin) || $this->fechaInicio <= $this->contrato->fecha_fin)
        ) {
        } else {
            $this->fechaInicio = "";
            $this->emit('error', 'Fecha fuera del rango de su Contrato.');
        }
    }
    public function updatedFechaFin()
    {
        if (
            $this->fechaFin >= $this->contrato->fecha_inicio
            && (is_null($this->contrato->fecha_fin) || $this->fechaFin <= $this->contrato->fecha_fin)
        ) {
        } else {
            $this->fechaFin = "";
            $this->emit('error', 'Fecha fuera del rango de su Contrato.');
        }
    }

    public function mount($designacione)
    {
        $this->designacione = $designacione;
        // $this->empleado = new Empleado();
    }

    public function seleccionaEmpleado($id, $contrato_id)
    {
        $this->empleadoid = $id;
        $this->empleado = Empleado::find($id);
        $this->nombres = $this->empleado->nombres . " " . $this->empleado->apellidos;

        $this->contrato = Rrhhcontrato::find($contrato_id);
    }

    public function updatedClienteid()
    {
        $this->clienteSeleccionado = Cliente::find($this->clienteid);
    }

    public function render()
    {
        // $empleados = DB::table('empleados')
        //     ->join('areas', 'areas.id', '=', 'empleados.area_id')
        //     ->join('oficinas', 'oficinas.id', '=', 'empleados.oficina_id')
        //     ->join('users', 'users.id', '=', 'empleados.user_id')
        //     ->where('areas.template', '=', 'OPER')
        //     ->where('users.status', '=', 1)
        //     ->select('empleados.*', 'oficinas.nombre as oficina')->get();



        $empleados = DB::table('empleados as e')
            ->join('rrhhcontratos as c', 'c.empleado_id', '=', 'e.id')
            ->where('c.activo', true) // contrato activo
            ->whereDate('c.fecha_inicio', '<=', now()) // ya comenzó
            ->where(function ($q) {
                $q->whereNull('c.fecha_fin') // sin fecha de fin
                    ->orWhere('c.fecha_fin', '>=', now()); // o aún no terminó
            })
            ->select(
                'e.id as empleado_id',
                'e.nombres',
                'e.apellidos',
                'e.cedula',
                'e.email',
                'e.telefono',
                'c.id as contrato_id',
                'c.fecha_inicio',
                'c.fecha_fin',
                'c.salario_basico',
                'c.moneda',
                'c.rrhhcargo_id',
                'c.rrhhtipocontrato_id'
            )
            ->orderBy('e.apellidos')
            ->get();


        $clientes = Cliente::all();
        $clientes->pluck('nombre', 'id');

        $this->emit('dataTableNormal');

        return view('livewire.admin.nueva-designacion', compact('empleados', 'clientes'));
    }

    protected $listeners = ['seleccionaEmpleado'];

    public function registrar()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $designacion = Designacione::create([
                "empleado_id" => $this->empleadoid,
                "turno_id" => $this->turnoid,
                "fechaInicio" => $this->fechaInicio,
                "fechaFin" => $this->fechaFin,
                "intervalo_hv" => $this->intervalo_hv,
                "observaciones" => $this->observaciones,
            ]);
            $turno = Turno::find($this->turnoid);
            $intervalo = [];
            $intervalo = crearIntervalo($turno->horainicio, $turno->horafin, $this->intervalo_hv);
            foreach ($intervalo as $item) {
                Intervalo::create([
                    "designacione_id" => $designacion->id,
                    "hora" => $item,
                ]);
            }

            $dias = Designaciondia::create([
                "designacione_id" => $designacion->id,
                "lunes" => $this->lunes,
                "martes" => $this->martes,
                "miercoles" => $this->miercoles,
                "jueves" => $this->jueves,
                "viernes" => $this->viernes,
                "sabado" => $this->sabado,
                "domingo" => $this->domingo,
            ]);



            DB::commit();
            redirect()->route('designaciones.index')->with('success', 'Designación registrada correctamente.');
        } catch (\Throwable $th) {
            // $this->emit('error', $th->getMessage());
            $this->emit('error', 'Ha ocurrido un error');
            DB::rollBack();
        }
    }
}
