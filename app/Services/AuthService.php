<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($identification_number, $password)
    {
        $user = User::where('identification_number', $identification_number)->first();
        if (!$user || !Hash::check($password, $password)) {
            return null;
        }
        return $user;
    }

    public function register($data)
    {
        return User::create([
            'name' => $data['name'],
            'identification_number' => $data['identification_number'],
            'password' => Hash::make($data['password']),
        ]);
    }
}