<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuiteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::prefix('suites')->group(function () {
    Route::get('/', [SuiteController::class, 'index']);
    Route::get('/{id}', [SuiteController::class, 'show']);
    Route::post('/', [SuiteController::class, 'store']);
    Route::delete('/{id}', [SuiteController::class, 'destroy']);
    Route::patch('/{id}', [SuiteController::class, 'update']);
    Route::get('/map', [SuiteController::class, 'suiteMap']);
});

// Gestão de Equipe (Usuários)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('users', UserController::class);
});
