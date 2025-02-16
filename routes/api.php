<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SedipranoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CargoController;

// Rutas públicas
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('sedipranos', [SedipranoController::class, 'store']); // Permitir crear sediprano sin autenticación

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('sedipranos', [SedipranoController::class, 'index']);
    Route::get('sedipranos/{id}', [SedipranoController::class, 'show']);
    Route::put('sedipranos/{id}', [SedipranoController::class, 'update']);
    Route::delete('sedipranos/{id}', [SedipranoController::class, 'destroy']);

    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
    Route::get('/dashboard/user-stats', [DashboardController::class, 'getUserStats']);
    Route::get('/dashboard/participacion', [DashboardController::class, 'getParticipacionStats']);
    Route::apiResource('areas', AreaController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('cargos', CargoController::class);
});
