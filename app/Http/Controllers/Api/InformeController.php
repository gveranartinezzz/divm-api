<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Informe;
use Illuminate\Http\Request;

class InformeController extends Controller
{
    protected function rules(): array
    {
        return [
            'paciente' => ['required', 'string', 'max:200'],
            'nombre_padre' => ['nullable', 'string', 'max:150'],
            'grado_estudios_padre' => ['nullable', 'string', 'max:100'],
            'ocupacion_padre' => ['nullable', 'string', 'max:150'],
            'edad_padre' => ['nullable', 'integer'],
            'nombre_madre' => ['nullable', 'string', 'max:150'],
            'grado_estudios_madre' => ['nullable', 'string', 'max:100'],
            'ocupacion_madre' => ['nullable', 'string', 'max:150'],
            'edad_madre' => ['nullable', 'integer'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'domicilio' => ['nullable', 'string'],
            'prueba_aplicada' => ['nullable', 'string'],
            'fecha_aplicacion' => ['nullable', 'date'],
            'aplicadora' => ['nullable', 'string'],
            'motivo_evaluacion' => ['nullable', 'string'],
            'hc_gestacion' => ['nullable', 'string'],
            'hc_talla_nacer' => ['nullable', 'string'],
            'hc_peso' => ['nullable', 'string'],
            'hc_apgar' => ['nullable', 'string'],
            'hc_alergias' => ['nullable', 'string'],
            'hc_diagnostico' => ['nullable', 'string'],
            'res_lenguaje' => ['nullable', 'string'],
            'res_anatomico' => ['nullable', 'string'],
            'res_discriminacion' => ['nullable', 'string'],
            'res_fonetica_auditiva' => ['nullable', 'string'],
            'res_lenguaje_espontaneo' => ['nullable', 'string'],
            'res_nivel_lenguaje' => ['nullable', 'string'],
            'res_conducta_valoracion' => ['nullable', 'string'],
            'des_cognitivo' => ['nullable', 'string'],
            'des_motor' => ['nullable', 'string'],
            'des_social' => ['nullable', 'string'],
            'observaciones' => ['nullable', 'string'],
            'ind_clinicas' => ['nullable', 'string'],
            'ind_familiares' => ['nullable', 'string'],
            'ind_adolescencia' => ['nullable', 'string'],
            'ind_escolares' => ['nullable', 'string'],
            'ind_rehabilitadores' => ['nullable', 'string'],
        ];
    }

    /** GET /api/informes */
    public function index(Request $request)
    {
        $query = Informe::query();

        if ($request->filled('buscar')) {
            $query->where('paciente', 'like', '%'.$request->buscar.'%');
        }

        return response()->json($query->orderByDesc('id')->get());
    }

    /** GET /api/informes/{informe} */
    public function show(Informe $informe)
    {
        return response()->json($informe);
    }

    /** POST /api/informes — equivalente a insertarinforme.php */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $informe = Informe::create($data);

        return response()->json($informe, 201);
    }

    /** PUT/PATCH /api/informes/{informe} — equivalente a actualizarinforme.php */
    public function update(Request $request, Informe $informe)
    {
        $data = $request->validate($this->rules());

        $informe->update($data);

        return response()->json($informe);
    }

    /** DELETE /api/informes/{informe} */
    public function destroy(Informe $informe)
    {
        $informe->delete();

        return response()->json(['message' => 'Informe eliminado.']);
    }
}
