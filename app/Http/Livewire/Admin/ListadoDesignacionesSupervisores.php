<?php

namespace App\Http\Livewire\Admin;

use App\Models\Cliente;
use App\Models\Designacionsupervisor;
use App\Models\Designacionsupervisorcliente;
use App\Models\Empleado;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ListadoDesignacionesSupervisores extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $busqueda = "", $filas = 10;
    public $fechaInicio,$fechaFin, $supervisor_id, $observaciones = '', $cliente_id = "", $arrayClientes = [], $procesando = false, $estado;
    public $designacion, $editMode = false;

    public function mount()
    {
        $this->fechaInicio = date('Y-m-d');
    }

    public function render()
    {
        $supervisores = Empleado::where('area_id', 9)->get();
        $clientes = Cliente::where('status', 1)->get();
        $resultados = Designacionsupervisor::paginate($this->filas);
        return view('livewire.admin.listado-designaciones-supervisores', compact('resultados', 'supervisores', 'clientes'))->extends('adminlte::page');
    }

    public function  create()
    {
        $this->emit('openModalCreate');
    }

    public function updatedBusqueda()
    {
        $this->resetPage();
    }

    public function updatedFilas()
    {
        $this->resetPage();
    }

    public function agregarCliente()
    {
        $this->validate([
            'cliente_id' => 'required',
        ]);
        $cliente = Cliente::find($this->cliente_id);
        if (!$cliente) {
            $this->emit('alert', 'error', 'El cliente seleccionado no es válido');
            return;
        }
        $this->arrayClientes[] = array(
            'id' => $cliente->id,
            'nombre' => $cliente->nombre,
        );
        $this->reset('cliente_id');
    }

    public function quitarCliente($i)
    {
        unset($this->arrayClientes[$i]);
        $this->arrayClientes = array_values($this->arrayClientes);
    }

    public function resetForm()
    {
        $this->reset(['supervisor_id', 'cliente_id', 'arrayClientes', 'fechaInicio', 'observaciones', 'editMode']);
    }

    public function registrar()
    {
        if ($this->procesando) {
            return;
        }

        $this->validate([
            'supervisor_id' => 'required',
            'arrayClientes' => 'required|array|min:1',
            'fechaInicio' => 'required|date',
        ]);
        $this->procesando = true;
        DB::beginTransaction();
        try {
            $designacion = Designacionsupervisor::create([
                'empleado_id' => $this->supervisor_id,
                'fechaInicio' => $this->fechaInicio,
                'observaciones' => $this->observaciones,
            ]);

            foreach ($this->arrayClientes as $cliente) {
                Designacionsupervisorcliente::create([
                    'designacionsupervisor_id' => $designacion->id,
                    'cliente_id' => $cliente['id'],
                ]);
            }
            DB::commit();
            $this->procesando = false;
            $this->resetForm();
            $this->emit('success', 'Designación registrada correctamente');
            $this->emit('closeModalCreate');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->procesando = false;
            $this->emit('error', $th->getMessage());
            // $this->emit('error', 'Ocurrió un error al registrar la designación');
        }
    }

    public function update()
    {
        if ($this->procesando) {
            return;
        }

        $this->validate([
            'supervisor_id' => 'required',
            'arrayClientes' => 'required|array|min:1',
            'fechaInicio' => 'required|date',
        ]);
        $this->procesando = true;
        DB::beginTransaction();
        try {
            $this->designacion->update([
                'empleado_id' => $this->supervisor_id,
                'fechaInicio' => $this->fechaInicio,
                'fechaFin' => $this->fechaFin,
                'observaciones' => $this->observaciones,
                'estado' => $this->estado,
            ]);
            $this->designacion->save();

            $this->designacion->designacionsupervisorclientes()->delete();

            foreach ($this->arrayClientes as $cliente) {
                Designacionsupervisorcliente::create([
                    'designacionsupervisor_id' => $this->designacion->id,
                    'cliente_id' => $cliente['id'],
                ]);
            }

            if ($this->designacion->estado) {
                $this->designacion->fechaFin = NULL;
                $this->designacion->save();
            } else {
                if (is_null($this->designacion->fechaFin)) {
                    $this->designacion->fechaFin = date('Y-m-d');
                    $this->designacion->save();
                }
            }

            DB::commit();
            $this->procesando = false;
            $this->resetForm();
            $this->emit('success', 'Designación actualizada correctamente');
            $this->emit('closeModalCreate');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->procesando = false;
            $this->emit('error', 'Ocurrió un error al actualizar la designación');
        }
    }

    public function editar($id)
    {

        $this->designacion = Designacionsupervisor::find($id);

        if ($this->designacion) {
            $this->resetForm();
            $this->supervisor_id = $this->designacion->empleado_id;
            $this->fechaInicio = $this->designacion->fechaInicio;
            $this->fechaFin = $this->designacion->fechaFin;
            $this->observaciones = $this->designacion->observaciones;
            $this->estado = $this->designacion->estado;
            foreach ($this->designacion->designacionsupervisorclientes as $item) {
                $this->arrayClientes[] = array(
                    'id' => $item->cliente->id,
                    'nombre' => $item->cliente->nombre,
                );
            }
        }
        $this->editMode = true;
        $this->emit('openModalCreate',);
    }
}
