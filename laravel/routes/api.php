<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('suites')->group(function () {
    Route::get('/', [\App\Http\Controllers\SuiteController::class, 'index']);
    Route::get('/map', [\App\Http\Controllers\SuiteController::class, 'suiteMap']);
});


// Gestão de Equipe (Usuários)
Route::apiResource('users', UserController::class)->except(['show']);
