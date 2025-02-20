<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SedipranoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\VotacionController;
use App\Http\Controllers\VotoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\VotacionAccesoController;

// Rutas públicas
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

// Rutas para el proceso de votación
Route::post('/votacion/validar-acceso', [VotacionAccesoController::class, 'validarAcceso']);
Route::post('/votacion/emitir-voto', [VotacionAccesoController::class, 'emitirVoto']);


// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
    Route::get('/dashboard/user-stats', [DashboardController::class, 'getUserStats']);
    Route::get('/dashboard/participacion', [DashboardController::class, 'getParticipacionStats']);
    Route::apiResource('areas', AreaController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('sedipranos', SedipranoController::class);
    Route::apiResource('cargos', CargoController::class);
    Route::apiResource('carreras', CarreraController::class);
    Route::apiResource('candidatos', CandidatoController::class);
    Route::apiResource('votaciones', VotacionController::class);
    Route::apiResource('votos', VotoController::class)->except(['update']);
    Route::apiResource('asistencias', AsistenciaController::class);
    Route::get('asistencias/fecha/{fecha}', [AsistenciaController::class, 'porFecha']);
    Route::get('asistencias/sediprano/{sedipranoId}', [AsistenciaController::class, 'porSediprano']);



});
