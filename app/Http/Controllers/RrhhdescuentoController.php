<?php

namespace App\Http\Controllers;

use App\Models\Rrhhdescuento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RrhhdescuentoController extends Controller
{
    public function data($contrato_id)
    {
        $descuentos = Rrhhdescuento::where('rrhhcontrato_id', $contrato_id)->get();

        return response()->json([
            'data' => $descuentos->map(function ($descuento) {
                $button = '<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalDescuento" onclick="editarDesc(' . $descuento->id . ')"><i class="fas fa-edit"></i></button> ';
                $estado = '<span class="badge badge-pill badge-success">Activo</span>';
                if (!$descuento->estado) {
                    $estado = '<span class="badge badge-pill badge-secondary">Anulado</span>';
                }

                return [
                    'id' => $descuento->id,
                    'rrhhcontrato_id' => $descuento->rrhhcontrato_id,
                    'fecha' => $descuento->fecha,
                    'rrhhtipodescuento' => $descuento->rrhhtipodescuento->nombre,
                    'empleado_id' => $descuento->empleado_id,
                    'cantidad' => $descuento->cantidad,
                    'monto' => number_format($descuento->monto, 2, '.'),
                    'subtotal' => number_format(($descuento->monto * $descuento->cantidad), 2, '.'),
                    'estado' => $estado,
                    'boton' => $button,

                ];
            }),
        ]);
    }

    public function edit(Request $request)
    {
        $descuento = Rrhhdescuento::find($request->rrhhdescuento_id);
        return response()->json(['success' => true, 'message' => $descuento]);
    }

    public function update(Request $request)
    {
        $descuento = Rrhhdescuento::find($request->rrhhdescuento_id);

        $request->validate([
            'fecha' => 'required|date',
            'monto' => 'required',
            'cantidad' => 'required',
            'rrhhtipodescuento_id' => 'required',
            'estado' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $descuento->fecha = $request->fecha;
            $descuento->monto = $request->monto;
            $descuento->rrhhtipodescuento_id = $request->rrhhtipodescuento_id;
            $descuento->cantidad = $request->cantidad;
            $descuento->estado = $request->estado;
            $descuento->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Descuento editado correctamente.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'rrhhcontrato_id' => 'required',
            'empleado_id' => 'required',
            'fecha' => 'required|date',
            'monto' => 'required',
            'cantidad' => 'required',
            'rrhhtipodescuento_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $fecha = explode('-', $request->fecha);

            $descuento = Rrhhdescuento::create([
                "rrhhcontrato_id" => $request->rrhhcontrato_id,
                "empleado_id" => $request->empleado_id,
                "fecha" => $request->fecha,
                "monto" => $request->monto,
                "rrhhtipodescuento_id" => $request->rrhhtipodescuento_id,
                "cantidad" => $request->cantidad,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Descuento registrado correctamente.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    
}
