<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AvanceController;
use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\Api\GraficaController;
use App\Http\Controllers\Api\HorarioController;
use App\Http\Controllers\Api\InformeController;
use App\Http\Controllers\Api\InformeValoracionController;
use App\Http\Controllers\Api\PacienteController;
use App\Http\Controllers\Api\PdfController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\RecomendacionController;
use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - DIVM Educación Especial
|--------------------------------------------------------------------------
| Todas las rutas están bajo el prefijo /api (automático en Laravel).
| Las rutas protegidas requieren un token Sanctum:
|   Authorization: Bearer {token}
*/

// ---------- Autenticación (públicas) ----------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/2fa/verificar', [AuthController::class, 'verificarDosFactores']);
Route::post('/2fa/reenviar', [AuthController::class, 'reenviarCodigo']);

// ---------- Rutas protegidas ----------
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Usuarios (personal) — solo Administrador puede gestionar
    Route::middleware('rol:Administrador')->group(function () {
        Route::apiResource('usuarios', UsuarioController::class)->except(['destroy']);
        Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy']);
    });
    Route::get('/usuarios/{usuario}', [UsuarioController::class, 'show']);

    // Pacientes
    Route::apiResource('pacientes', PacienteController::class);

    // Informes (formato largo, tipo expediente)
    Route::apiResource('informes', InformeController::class);
    Route::get('/informes/{informe}/pdf', [PdfController::class, 'informe']);

    // Informes de valoración (banco de valoraciones por paciente)
    Route::get('/valoraciones', [InformeValoracionController::class, 'index']);
    Route::get('/valoraciones/{valoracion}', [InformeValoracionController::class, 'show']);
    Route::post('/valoraciones', [InformeValoracionController::class, 'store']);

    // Planes de intervención
    Route::apiResource('planes', PlanController::class);

    // Recomendaciones
    Route::apiResource('recomendaciones', RecomendacionController::class);

    // Avances / bitácora de sesiones
    Route::get('/avances', [AvanceController::class, 'index']);
    Route::get('/avances/{avance}', [AvanceController::class, 'show']);
    Route::post('/avances', [AvanceController::class, 'store']);
    Route::get('/avances/{avance}/pdf', [PdfController::class, 'avance']);

    // Horarios de atención
    Route::get('/horarios', [HorarioController::class, 'index']);
    Route::post('/horarios', [HorarioController::class, 'store']);
    Route::delete('/horarios/{horario}', [HorarioController::class, 'destroy']);

    // Estadísticas para gráficas
    Route::get('/grafica/diagnosticos', [GraficaController::class, 'diagnosticos']);

    // Asistente virtual (chatbot)
    Route::post('/chatbot', [ChatbotController::class, 'responder']);
});
