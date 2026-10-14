<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /** GET /api/pacientes */
    public function index(Request $request)
    {
        $query = Paciente::query();

        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%'.$request->buscar.'%');
        }

        return response()->json($query->orderBy('nombre')->get());
    }

    /** GET /api/pacientes/{paciente} */
    public function show(Paciente $paciente)
    {
        return response()->json($paciente->load('avances'));
    }

    /**
     * POST /api/pacientes
     * Equivalente a insertaregistro.php.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'edad' => ['required', 'integer', 'min:0'],
            'direccion' => ['nullable', 'string'],
            'escolarizado' => ['required', 'in:Sí,No'],
            'diagnostico' => ['nullable', 'string', 'max:255'],
            'motivo_consulta' => ['nullable', 'string'],
            'madre' => ['nullable', 'string', 'max:150'],
            'padre' => ['nullable', 'string', 'max:150'],
        ]);

        $data['estatus'] = 'Activo';

        $paciente = Paciente::create($data);

        return response()->json($paciente, 201);
    }

    /**
     * PUT/PATCH /api/pacientes/{paciente}
     * Equivalente a actualizaregistro.php.
     */
    public function update(Request $request, Paciente $paciente)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'edad' => ['required', 'integer', 'min:0'],
            'direccion' => ['nullable', 'string'],
            'escolarizado' => ['required', 'in:Sí,No'],
            'diagnostico' => ['nullable', 'string', 'max:255'],
            'motivo_consulta' => ['nullable', 'string'],
            'madre' => ['nullable', 'string', 'max:150'],
            'padre' => ['nullable', 'string', 'max:150'],
        ]);

        $paciente->update($data);

        return response()->json($paciente);
    }

    /**
     * DELETE /api/pacientes/{paciente}
     * El sistema original no borraba pacientes; aquí se añade el mismo
     * patrón de baja lógica que se usa para usuarios.
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->update(['estatus' => 'Inactivo']);

        return response()->json(['message' => 'Paciente marcado como inactivo.']);
    }
}
