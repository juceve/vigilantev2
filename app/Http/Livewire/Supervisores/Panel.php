<?php

namespace App\Http\Livewire\Supervisores;

use Illuminate\Support\Facades\Session;
use Livewire\Component;


class Panel extends Component
{
    public $inspeccionActiva;

    public function mount()
    {
        $this->inspeccionActiva = Session::get('inspeccion_activa');

        if (is_null($this->inspeccionActiva)) {
            return redirect()->route('home')->with('error', 'No existe una Inspección activa');
        }
        
    }
    
    public function render()
    {
        return view('livewire.supervisores.panel');
    }
}
