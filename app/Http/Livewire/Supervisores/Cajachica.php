<?php

namespace App\Http\Livewire\Supervisores;

use App\Models\Cajachica as ModelsCajachica;
use App\Models\Designacionsupervisor;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Cajachica extends Component
{
    public $designacion, $cajachica;
    public function mount()
    {
        $designacion_id = Session::get("designacion-super");
        $this->designacion = Designacionsupervisor::find($designacion_id);
        $this->cajachica = ModelsCajachica::where("empleado_id", $this->designacion->empleado_id)
            ->where("estado", "ACTIVA")
            ->where("gestion", date('Y'))
            ->orderBy("id", "asc")
            ->first();
    }
    public function render()
    {
        return view('livewire.supervisores.cajachica')->extends('layouts.app');
    }
}
