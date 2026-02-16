<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/check-status/{taskId}', [AuthController::class, 'checkStatus']);

Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard')->middleware('auth');