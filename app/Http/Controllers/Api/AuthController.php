<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CodigoVerificacionMail;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * POST /api/login
     * Igual que login.php pero devolviendo JSON. Si el usuario tiene
     * dos_factores_activado = true, no entrega token todavía: primero
     * hay que llamar a /api/2fa/verificar.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => ['required', 'email'],
            'contrasena' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Datos inválidos', 'errors' => $validator->errors()], 422);
        }

        $usuario = Usuario::where('correo', $request->correo)
            ->where('estado', 'Activo')
            ->first();

        if (! $usuario || ! Hash::check($request->contrasena, $usuario->password)) {
            return response()->json(['message' => 'Correo o contraseña incorrectos.'], 401);
        }

        if ($usuario->dos_factores_activado) {
            $codigo = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            $usuario->forceFill([
                'codigo_verificacion' => $codigo,
                'fecha_codigo' => now(),
            ])->save();

            Mail::to($usuario->correo)->send(new CodigoVerificacionMail($usuario, $codigo));

            return response()->json([
                'requiere_2fa' => true,
                'correo' => $usuario->correo,
                'message' => 'Se envió un código de verificación a tu correo.',
            ]);
        }

        $token = $usuario->createToken('api')->plainTextToken;

        return response()->json([
            'requiere_2fa' => false,
            'token' => $token,
            'usuario' => $usuario,
        ]);
    }

    /**
     * POST /api/2fa/verificar
     * Equivalente a validar_2fa.php: valida el código de 6 dígitos
     * (expira 10 minutos después de haberse generado) y entrega el token.
     */
    public function verificarDosFactores(Request $request)
    {
        $request->validate([
            'correo' => ['required', 'email'],
            'codigo' => ['required', 'string', 'size:6'],
        ]);

        $usuario = Usuario::where('correo', $request->correo)->first();

        if (! $usuario || ! $usuario->codigo_verificacion) {
            return response()->json(['message' => 'Solicita un nuevo código de verificación.'], 422);
        }

        if (now()->greaterThan($usuario->fecha_codigo?->addMinutes(10))) {
            return response()->json(['message' => 'El código expiró. Inicia sesión de nuevo.'], 422);
        }

        if (! hash_equals($usuario->codigo_verificacion, $request->codigo)) {
            return response()->json(['message' => 'Código incorrecto.'], 422);
        }

        $usuario->forceFill([
            'codigo_verificacion' => null,
            'fecha_codigo' => null,
        ])->save();

        $token = $usuario->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'usuario' => $usuario,
        ]);
    }

    /**
     * POST /api/2fa/reenviar
     * Equivalente a reenviar_codigo.php.
     */
    public function reenviarCodigo(Request $request)
    {
        $request->validate(['correo' => ['required', 'email']]);

        $usuario = Usuario::where('correo', $request->correo)->first();

        if (! $usuario) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        $codigo = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $usuario->forceFill([
            'codigo_verificacion' => $codigo,
            'fecha_codigo' => now(),
        ])->save();

        Mail::to($usuario->correo)->send(new CodigoVerificacionMail($usuario, $codigo));

        return response()->json(['message' => 'Código reenviado correctamente.']);
    }

    /**
     * POST /api/logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada.']);
    }

    /**
     * GET /api/me
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
