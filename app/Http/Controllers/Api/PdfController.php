<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AvancePaciente;
use App\Models\Informe;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    /**
     * GET /api/informes/{informe}/pdf
     * Equivalente a generar_pdf.php.
     */
    public function informe(Informe $informe)
    {
        $pdf = Pdf::loadView('pdf.informe', ['d' => $informe])
            ->setPaper('a4', 'portrait');

        return $pdf->stream("informe_{$informe->id}.pdf");
    }

    /**
     * GET /api/avances/{avance}/pdf
     * Equivalente a pdf_avance.php.
     */
    public function avance(AvancePaciente $avance)
    {
        $avance->load(['paciente', 'usuario']);

        $pdf = Pdf::loadView('pdf.avance', ['d' => $avance])
            ->setPaper('a4', 'portrait');

        return $pdf->stream("avance_{$avance->id}.pdf");
    }
}
