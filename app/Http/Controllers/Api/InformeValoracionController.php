<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InformeValoracion;
use Illuminate\Http\Request;

class InformeValoracionController extends Controller
{
    /** GET /api/valoraciones */
    public function index(Request $request)
    {
        $query = InformeValoracion::with(['paciente', 'usuario']);

        if ($request->filled('id_paciente')) {
            $query->where('id_paciente', $request->id_paciente);
        }

        return response()->json($query->orderByDesc('id')->get());
    }

    /** GET /api/valoraciones/{valoracion} */
    public function show(InformeValoracion $valoracion)
    {
        return response()->json($valoracion->load(['paciente', 'usuario']));
    }

    /**
     * POST /api/valoraciones
     * Equivalente a insertarvaloracion.php. El usuario que registra se
     * toma del token autenticado, no de un campo enviado por el cliente.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_paciente' => ['required', 'exists:pacientes,id'],
            'prueba_aplicada' => ['required', 'string'],
            'aplicadora' => ['required', 'string'],
            'motivo_evaluacion' => ['required', 'string'],
            'hc_gestacion' => ['nullable', 'string'],
            'hc_talla_nacer' => ['nullable', 'string', 'max:100'],
            'hc_diagnostico' => ['required', 'string'],
            'des_cognitivo' => ['required', 'string'],
            'des_motor' => ['required', 'string'],
            'des_social' => ['required', 'string'],
            'res_lenguaje' => ['required', 'string'],
            'res_conducta_valoracion' => ['required', 'string'],
            'ind_escolares' => ['nullable', 'string'],
            'ind_clinicas' => ['nullable', 'string'],
            'ind_familiares' => ['nullable', 'string'],
            'ind_rehabilitadores' => ['nullable', 'string'],
        ]);

        $data['id_usuario'] = $request->user()->id_usuario;

        $valoracion = InformeValoracion::create($data);

        return response()->json($valoracion, 201);
    }
}
