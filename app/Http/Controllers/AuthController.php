<?php

namespace App\Http\Controllers;


use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identification_number' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('identification_number', $request->identification_number)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['identification_number' => 'Credenciales inválidas']);
        }

        // ✅ Login correcto usando Facade
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    private function ensureRealtimeSessionGeneral(Request $request): void
    {
        // 1️⃣ Asegurar que exista "sc"
        if (!$request->session()->has('sc')) {
            $request->session()->put('sc', []);
        }

        $sc = (array) $request->session()->get('sc', []);

        $mainUrl = env('APP_URL', 'http://localhost:8006');
        $baseUrl = rtrim(env('VITE_NODE_BACKEND_URL', 'http://localhost:3005'), '/');

        // Valores base
        $sc['action'] = $sc['action'] ?? 'AUTH';
        $sc['projectId'] = $sc['projectId'] ?? env('PROJECT_ID');
        $sc['url'] = $mainUrl;

        /*
        |--------------------------------------------------------------------------
        | 2️⃣ Si ya existe sesión realtime → no crear otra
        |--------------------------------------------------------------------------
        */
        if (!empty($sc['rt_session_id'])) {
            $request->session()->put('sc', $sc);
            $request->session()->save();
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | 3️⃣ No existe → crear nueva sesión en Node
        |--------------------------------------------------------------------------
        */
        try {
            $response = Http::asJson()
                ->timeout(8)
                ->post($baseUrl . '/api/sessions', $sc);

            if ($response->successful()) {
                $sc['rt_session_id'] = $response->json('sessionId');
                $sc['rt_session_token'] = $response->json('sessionToken');

                $nodeAction = $response->json('session.action') ?? $response->json('action');
                if ($nodeAction) {
                    $sc['action'] = $nodeAction;
                }

                $request->session()->put('sc', $sc);
                $request->session()->save();
            }
        } catch (\Throwable $e) {
            // opcional: loguear error
            // \Log::error($e->getMessage());
        }
    }

    public function initData(Request $request)
    {
        $this->ensureRealtimeSessionGeneral($request);

        $sc = (array) $request->session()->get('sc', []);

        return response()->json([
            'ok' => true,
            'nodeUrl' => env('NODE_BACKEND_URL', 'http://localhost:3005'),
            'sessionId' => Arr::get($sc, 'rt_session_id'),
            'sessionToken' => Arr::get($sc, 'rt_session_token'),
            'action' => Arr::get($sc, 'action'),
            'origin' => Arr::get($sc, 'url'),
        ]);
    }
}