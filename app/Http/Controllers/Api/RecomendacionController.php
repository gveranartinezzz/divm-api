<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recomendacion;
use Illuminate\Http\Request;

class RecomendacionController extends Controller
{
    protected function rules(): array
    {
        return [
            'madre' => ['required', 'string', 'max:150'],
            'padre' => ['required', 'string', 'max:150'],
            'paciente' => ['required', 'string', 'max:150'],
            'escuela_procedencia' => ['nullable', 'string', 'max:255'],
            'grado' => ['nullable', 'in:Estancia,Preescolar,Primaria,Secundaria,Preparatoria,Universidad'],
            'recomendacion' => ['required', 'string'],
            'notas' => ['nullable', 'string'],
        ];
    }

    /** GET /api/recomendaciones */
    public function index()
    {
        return response()->json(Recomendacion::orderByDesc('id')->get());
    }

    /** GET /api/recomendaciones/{recomendacion} */
    public function show(Recomendacion $recomendacion)
    {
        return response()->json($recomendacion);
    }

    /** POST /api/recomendaciones — equivalente a insertarrecomendaciones.php */
    public function store(Request $request)
    {
        $recomendacion = Recomendacion::create($request->validate($this->rules()));

        return response()->json($recomendacion, 201);
    }

    /** PUT/PATCH /api/recomendaciones/{recomendacion} — equivalente a actualizarrecomendacion.php */
    public function update(Request $request, Recomendacion $recomendacion)
    {
        $recomendacion->update($request->validate($this->rules()));

        return response()->json($recomendacion);
    }

    /** DELETE /api/recomendaciones/{recomendacion} */
    public function destroy(Recomendacion $recomendacion)
    {
        $recomendacion->delete();

        return response()->json(['message' => 'Recomendación eliminada.']);
    }
}
