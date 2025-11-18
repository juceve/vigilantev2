<?php

namespace App\Http\Livewire\Admin;

use App\Exports\NovedadesExport;
use App\Models\Cliente;
use App\Models\Novedade;
use App\Models\Vwnovedade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Registrosnovedades extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $clientes, $cliente_id = "",  $inicio, $final, $search = "", $empleado_id = "", $auxcliente = "";
    public $novedade = null;

    public function mount()
    {
        $this->inicio = date('Y-m-d');
        $this->final = date('Y-m-d');
        $this->clientes = Cliente::all()->pluck('nombre', 'id');
        $this->novedade = new Novedade();
    }
    public function render()
    {
        $resultados = NULL;
        $sql = "";
        $empleados = [];
        if ($this->cliente_id != "") {
            $empleados = DB::select("SELECT DISTINCT(empleado_id) id,empleado nombre FROM vwasistencias WHERE cliente_id=" . $this->cliente_id);
            if ($this->auxcliente != $this->cliente_id) {
                $this->auxcliente = $this->cliente_id;
                $this->empleado_id = "";
            }

            if ($this->empleado_id == "") {
                $resultados = Vwnovedade::where([
                    ["fecha", ">=", $this->inicio],
                    ["fecha", "<=", $this->final],
                    ["cliente_id", $this->cliente_id],
                    ['empleado', 'LIKE', '%' . $this->search . '%']
                ])->orWhere(
                    [
                        ["fecha", ">=", $this->inicio],
                        ["fecha", "<=", $this->final],
                        ["cliente_id", $this->cliente_id],
                        ['turno', 'LIKE', '%' . $this->search . '%']
                    ]
                )
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
            } else {
                $resultados = Vwnovedade::where([
                    ["fecha", ">=", $this->inicio],
                    ["fecha", "<=", $this->final],
                    ["cliente_id", $this->cliente_id],
                    ['empleado_id', $this->empleado_id],
                    ['turno', 'LIKE', '%' . $this->search . '%']
                ])->orWhere(
                    [
                        ["fecha", ">=", $this->inicio],
                        ["fecha", "<=", $this->final],
                        ["cliente_id", $this->cliente_id],
                        ['empleado_id', $this->empleado_id],
                        ['turno', 'LIKE', '%' . $this->search . '%']
                    ]
                )
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
            }
            // $this->resetPage();

            $parametros = array($this->cliente_id, $this->inicio, $this->final, $this->search, $this->empleado_id);
            Session::put('param-novedades', $parametros);
        }

        return view('livewire.admin.registrosnovedades', compact('resultados', 'empleados'))->extends('adminlte::page');
    }

    public function verInfo($id)
    {
        $this->novedade = Vwnovedade::find($id);
    }

    public function exporExcel()
    {
        $cliente = Cliente::find($this->cliente_id);
        return Excel::download(new NovedadesExport(), 'Novedades_' . $cliente->nombre . '_' . date('His') . '.xlsx');
    }

    public function updatedClienteId()
    {
        $this->resetPage();
    }
    public function updatedEstado()
    {
        $this->resetPage();
    }
    public function updatedInicio()
    {
        $this->resetPage();
    }
    public function updatedFinal()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
}
