<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    protected function rules(): array
    {
        return [
            'paciente' => ['nullable', 'string', 'max:200'],
            'padre' => ['nullable', 'string', 'max:100'],
            'madre' => ['nullable', 'string', 'max:100'],
            'terapia_comunicativa' => ['nullable', 'string'],
            'terapia_sensorial' => ['nullable', 'string'],
            'terapia_aprendizaje' => ['nullable', 'string'],
            'terapia_ocupacional' => ['nullable', 'string'],
            'terapia_atencion_concentracion' => ['nullable', 'string'],
            'terapia_educacion_emocional' => ['nullable', 'string'],
        ];
    }

    /** GET /api/planes */
    public function index()
    {
        return response()->json(Plan::orderByDesc('id')->get());
    }

    /** GET /api/planes/{plan} */
    public function show(Plan $plan)
    {
        return response()->json($plan);
    }

    /** POST /api/planes — equivalente a insertarplan.php */
    public function store(Request $request)
    {
        $plan = Plan::create($request->validate($this->rules()));

        return response()->json($plan, 201);
    }

    /** PUT/PATCH /api/planes/{plan} — equivalente a actualizarplan.php */
    public function update(Request $request, Plan $plan)
    {
        $plan->update($request->validate($this->rules()));

        return response()->json($plan);
    }

    /** DELETE /api/planes/{plan} */
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return response()->json(['message' => 'Plan eliminado.']);
    }
}
