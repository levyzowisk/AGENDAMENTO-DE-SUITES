<?php

declare(strict_types=1);

use App\Http\Controllers\SuiteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('suites')->group(function () {
    Route::get('/', [SuiteController::class, 'index']);
    Route::get('/map', [SuiteController::class, 'suiteMap']);
});

// Gestão de Equipe (Usuários)
Route::apiResource('users', UserController::class)->except(['show']);
