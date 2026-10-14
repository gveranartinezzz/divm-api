<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AvancePaciente;
use Illuminate\Http\Request;

class AvanceController extends Controller
{
    /** GET /api/avances */
    public function index(Request $request)
    {
        $query = AvancePaciente::with(['paciente', 'usuario']);

        if ($request->filled('paciente_id')) {
            $query->where('paciente_id', $request->paciente_id);
        }

        return response()->json($query->orderByDesc('fecha_sesion')->get());
    }

    /** GET /api/avances/{avance} */
    public function show(AvancePaciente $avance)
    {
        return response()->json($avance->load(['paciente', 'usuario']));
    }

    /**
     * POST /api/avances
     * Equivalente a insertar_avance.php. usuario_id se toma del token,
     * no del cuerpo de la petición.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'paciente_id' => ['required', 'exists:pacientes,id'],
            'fecha_sesion' => ['required', 'date'],
            'hora_inicio' => ['nullable', 'date_format:H:i'],
            'hora_fin' => ['nullable', 'date_format:H:i'],
            'estatus_sesion' => ['required', 'in:Asistió,Falta Justificada,Falta Injustificada,Cancelada'],
            'actividades_realizadas' => ['nullable', 'string'],
            'observaciones_comportamiento' => ['nullable', 'string'],
            'logros_obtenidos' => ['nullable', 'string'],
            'tareas_o_recomendaciones' => ['nullable', 'string'],
        ]);

        $data['usuario_id'] = $request->user()->id_usuario;

        $avance = AvancePaciente::create($data);

        return response()->json($avance, 201);
    }
}
