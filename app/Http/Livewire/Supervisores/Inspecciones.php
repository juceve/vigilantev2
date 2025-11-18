<?php

namespace App\Http\Livewire\Supervisores;

use App\Models\Designacionsupervisor;
use App\Models\Inspeccion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Inspecciones extends Component
{
    public $designaciones;
    public function mount($designacion_id)
    {
        $this->designaciones = Designacionsupervisor::find($designacion_id);
    }
    public function render()
    {
        return view('livewire.supervisores.inspecciones');
    }

    protected $listeners = ['iniciarInspeccion' => 'iniciarInspeccion', 'finalizar' => 'finalizarInspeccionActiva'];

    public function iniciarInspeccion($cliente_id)
    {
        $inspeccionActiva = Inspeccion::where('designacionsupervisor_id', $this->designaciones->id)
            ->where('status', 1)
            ->get();

        if ($inspeccionActiva->count() > 0) {
            $this->emit('warning', 'Existen Inspeciones activas!');
            return;
        }
        DB::beginTransaction();
        try {
            $inspeccion = Inspeccion::create([
                'designacionsupervisor_id' => $this->designaciones->id,
                'cliente_id' => $cliente_id,
                'inicio' => date('Y-m-d H:i:s')
            ]);
            DB::commit();
            Session::put('inspeccion_activa', $inspeccion);
            return redirect()->route('supervisores.panel');
            // $this->emit('success', 'Inspeccion creada correctamente');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('error', 'Ha ocurrido un error');
        }
    }

    public function finalizarInspeccionActiva()
    {
        if (Session::get('inspeccion_activa')) {
            $inspeccionActiva = Session::get('inspeccion_activa');
            $inspeccionActiva->fin = date('Y-m-d H:i:s');
            $inspeccionActiva->status = false;
            $inspeccionActiva->save();

            Session::put('inspeccion_activa', null);
            Session::forget('inspeccion_activa');

            $this->emit('success', 'Inspección finalizada correctamente!');
        } else {
            $this->emit('warning', 'No existen inspecciones activas.');
        }
    }
}
