<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('suites')->group(function () {
    Route::get('/', [\App\Http\Controllers\SuiteController::class, 'index']);
    Route::get('/map', [\App\Http\Controllers\SuiteController::class, 'suiteMap']);
});


