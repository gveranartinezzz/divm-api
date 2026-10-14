<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /** GET /api/usuarios */
    public function index()
    {
        return response()->json(Usuario::orderBy('nombre')->get());
    }

    /** GET /api/usuarios/{usuario} */
    public function show(Usuario $usuario)
    {
        return response()->json($usuario);
    }

    /**
     * POST /api/usuarios
     * Equivalente a insertarusuario.php: valida correo único, hashea password.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apaterno' => ['required', 'string', 'max:100'],
            'amaterno' => ['required', 'string', 'max:100'],
            'correo' => ['required', 'email', 'max:100', 'unique:usuarios,correo'],
            'contrasena' => ['required', 'string', 'min:5'],
            'rol' => ['required', 'in:Administrador,Personal'],
            'estado' => ['required', 'in:Activo,Inactivo'],
        ]);

        $usuario = Usuario::create([
            'nombre' => $data['nombre'],
            'apaterno' => $data['apaterno'],
            'amaterno' => $data['amaterno'],
            'correo' => $data['correo'],
            'password' => Hash::make($data['contrasena']),
            'rol' => $data['rol'],
            'estado' => $data['estado'],
            'dos_factores_activado' => true,
        ]);

        return response()->json($usuario, 201);
    }

    /**
     * PUT/PATCH /api/usuarios/{usuario}
     * Equivalente a actualizarusuario.php: la contraseña solo se cambia
     * si se envía 'nueva_contrasena'.
     */
    public function update(Request $request, Usuario $usuario)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apaterno' => ['required', 'string', 'max:100'],
            'correo' => ['required', 'email', 'max:100', 'unique:usuarios,correo,'.$usuario->id_usuario.',id_usuario'],
            'rol' => ['required', 'in:Administrador,Personal'],
            'estado' => ['required', 'in:Activo,Inactivo'],
            'nueva_contrasena' => ['nullable', 'string', 'min:5'],
        ]);

        $usuario->nombre = $data['nombre'];
        $usuario->apaterno = $data['apaterno'];
        $usuario->correo = $data['correo'];
        $usuario->rol = $data['rol'];
        $usuario->estado = $data['estado'];

        if (! empty($data['nueva_contrasena'])) {
            $usuario->password = Hash::make($data['nueva_contrasena']);
        }

        $usuario->save();

        return response()->json($usuario);
    }

    /**
     * DELETE /api/usuarios/{usuario}
     * Igual que eliminar.php: no borra, solo marca estado = Inactivo.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->update(['estado' => 'Inactivo']);

        return response()->json(['message' => 'Usuario desactivado correctamente.']);
    }
}
