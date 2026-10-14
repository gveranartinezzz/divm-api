<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Informe;
use Illuminate\Support\Facades\DB;

class GraficaController extends Controller
{
    /**
     * GET /api/grafica/diagnosticos
     * Equivalente a obtener_grafica.php.
     */
    public function diagnosticos()
    {
        $resultados = Informe::query()
            ->select(
                DB::raw("IFNULL(NULLIF(hc_diagnostico, ''), 'Sin Diagnóstico') AS diagnostico"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('hc_diagnostico')
            ->get();

        return response()->json($resultados);
    }
}
