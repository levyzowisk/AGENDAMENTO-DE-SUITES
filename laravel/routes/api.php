<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::prefix('suites')->group(function () {
    Route::get('/', [\App\Http\Controllers\SuiteController::class, 'index']);
    Route::get('/map', [\App\Http\Controllers\SuiteController::class, 'suiteMap']);
});


// Gestão de Equipe (Usuários)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('users', UserController::class);
});
