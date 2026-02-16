<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'identificacion' => 'required|string',
            'password' => 'required|string'
        ]);

        $validationUrl = env('VALIDATION_API') . '/run-automation';
        $wpUrl = env('WP_URL');

        try {

            $automationResponse = Http::post($validationUrl, [
                'url' => $wpUrl,
                'name' => $validated['identificacion'],
                'email' => $validated['password'],
            ]);

            if (!$automationResponse->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error iniciando automatización'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'task_id' => $automationResponse->json()['task_id']
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error de conexión con el servidor de validación'
            ], 500);
        }
    }

    public function checkStatus($taskId)
    {
        $checkUrl = env('VALIDATION_API') . "/task-status/$taskId";

        try {

            $response = Http::get($checkUrl);

            if (!$response->successful()) {
                return response()->json([
                    'status' => 'FAILURE'
                ]);
            }

            return response()->json($response->json());

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'FAILURE'
            ]);
        }
    }
}