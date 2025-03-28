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
use App\Http\Controllers\EventoController;

// Rutas públicas
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

// Ruta pública para validar QR y registrar asistencia
Route::post('sedipranos/validate-qr', [SedipranoController::class, 'validateQr']);

// Rutas para el proceso de votación
Route::post('/votacion/validar-acceso', [VotacionAccesoController::class, 'validarAcceso']);
Route::post('/votacion/emitir-voto', [VotacionAccesoController::class, 'emitirVoto']);
Route::get('/votaciones/estado', [VotacionController::class, 'getEstadoVotaciones']); // Nueva ruta para comprobar el estado de las votaciones

// Rutas públicas para asistencias
Route::post('/asistencias/registrar', [AsistenciaController::class, 'registrarAsistencia']);
Route::get('/asistencias/publicas', [AsistenciaController::class, 'asistenciasPublicas']); // Nueva ruta pública para consultar asistencias
Route::get('/asistencias/evento/{eventoId}', [AsistenciaController::class, 'asistenciasPorEvento']); // Nueva ruta para filtrar por evento

// Rutas públicas
Route::get('eventos/disponibles', [EventoController::class, 'eventosDisponibles']);

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
    Route::get('sedipranos-with-relations', [SedipranoController::class, 'getSedipranosWithRelations']);
    Route::post('sedipranos/{id}/generate-qr', [SedipranoController::class, 'generateQrCode']);
    Route::apiResource('cargos', CargoController::class);
    Route::apiResource('carreras', CarreraController::class);
    Route::apiResource('candidatos', CandidatoController::class);
    Route::apiResource('votaciones', VotacionController::class);
    Route::apiResource('votos', VotoController::class)->except(['update']);

    // CRUD de asistencias (protegido)
    Route::apiResource('asistencias', AsistenciaController::class);
    Route::get('asistencias/fecha/{fecha}', [AsistenciaController::class, 'porFecha']);
    Route::get('asistencias/sediprano/{sedipranoId}', [AsistenciaController::class, 'porSediprano']);
    Route::get('eventos/{evento}/asistencias', [AsistenciaController::class, 'listarAsistenciasPorEvento']);

    // CRUD de eventos (protegido)
    Route::apiResource('eventos', EventoController::class);
});
