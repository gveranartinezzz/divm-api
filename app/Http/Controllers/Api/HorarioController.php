<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HorarioAtencion;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /** GET /api/horarios */
    public function index(Request $request)
    {
        $query = HorarioAtencion::with('usuario');

        if ($request->filled('id_usuario')) {
            $query->where('id_usuario', $request->id_usuario);
        }

        return response()->json($query->get());
    }

    /** POST /api/horarios — equivalente a insertardistribucion.php */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario' => ['required', 'exists:usuarios,id_usuario'],
            'paciente' => ['required', 'string', 'max:200'],
            'dia_semana' => ['required', 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['required', 'date_format:H:i'],
        ]);

        $horario = HorarioAtencion::create($data);

        return response()->json($horario, 201);
    }

    /** DELETE /api/horarios/{horario} */
    public function destroy(HorarioAtencion $horario)
    {
        $horario->delete();

        return response()->json(['message' => 'Horario eliminado.']);
    }
}
