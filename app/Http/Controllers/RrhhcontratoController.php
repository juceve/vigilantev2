<?php

namespace App\Http\Controllers;

use App\Models\Rrhhcontrato;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RrhhcontratoController extends Controller
{
    public function contratoPdf($fecha)
    {
        $designacione = Session::get('designacione_data');
        $contrato = Session::get('contrato_data');
        $empleado = $contrato->empleado;

        $pdf = Pdf::loadView('pdfs.contrato', compact('designacione', 'contrato', 'empleado', 'fecha'))
            ->setPaper([0, 0, 609.4488, 935.433], 'portrait');

        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();

        // Posición: centrado abajo
        $width = $canvas->get_width();
        $height = $canvas->get_height();
        $canvas->page_text($width / 2, $height - 30, "{PAGE_NUM}", null, 10, [0, 0, 0]);

        return $pdf->stream('Contrato_' . $contrato->id . '_' . date('YmdHis') . '.pdf');
    }
}
