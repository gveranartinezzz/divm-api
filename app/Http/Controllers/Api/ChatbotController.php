<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    /**
     * POST /api/chatbot
     * Equivalente a chatbot_proxy.php, pero la API key ahora vive en
     * .env (GROQ_API_KEY) en vez de estar escrita en el código.
     */
    public function responder(Request $request)
    {
        $request->validate([
            'messages' => ['required', 'array', 'min:1'],
        ]);

        $apiKey = config('services.groq.key');

        if (! $apiKey) {
            return response()->json(['error' => 'El chatbot no está configurado (falta GROQ_API_KEY).'], 500);
        }

        $systemPrompt = "Eres el asistente virtual del Centro DIVM, especializado en informes pedagógicos y "
            ."evaluación del desarrollo infantil. Ayudas al personal clínico y administrativo con:\n"
            ."- Registro y consulta de informes pedagógicos en el sistema\n"
            ."- Interpretación de áreas de desarrollo: cognitiva, motriz y social\n"
            ."- Orientación sobre diagnósticos como Autismo, TDAH, Síndrome de Down, Parálisis Cerebral, etc.\n"
            ."- Guía sobre campos del formulario: gestación, talla/peso, pruebas aplicadas, aplicadora, motivo de evaluación\n"
            ."- Indicaciones clínicas, familiares, escolares y rehabilitadoras\n"
            ."- Uso del historial clínico, filtros, estadísticas y generación de PDFs\n"
            .'Responde siempre en español, de manera cálida, profesional y concisa.';

        $mensajes = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $request->input('messages')
        );

        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'max_tokens' => 1000,
                'messages' => $mensajes,
            ]);

        if ($response->failed()) {
            return response()->json([
                'error' => $response->json('error.message', 'Error al contactar al asistente.'),
            ], $response->status());
        }

        $texto = $response->json('choices.0.message.content', 'No pude generar una respuesta.');

        return response()->json([
            'content' => [['type' => 'text', 'text' => $texto]],
        ]);
    }
}
