<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}