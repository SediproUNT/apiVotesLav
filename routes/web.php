<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebVotacionController;
use App\Http\Controllers\PublicPanelController;

Route::get('/', function () {
    return redirect()->route('votacion.index');
});

// Rutas de votación existentes
Route::get('/votacion', [WebVotacionController::class, 'index'])->name('votacion.index');
Route::post('/votacion/validar', [WebVotacionController::class, 'validar'])->name('votacion.validar');
Route::get('/emitir-voto', [WebVotacionController::class, 'mostrarVotacion'])->name('votacion.emitir');
Route::post('/votacion/procesar', [WebVotacionController::class, 'procesarVoto'])->name('votacion.procesar');

// Rutas públicas para el panel de SEDIPRO y asistencias
Route::prefix('panel-publico')->group(function () {
    // Dashboard y vistas básicas
    Route::get('/', [PublicPanelController::class, 'index'])->name('public.dashboard');
    
    // CRUD de Sedipranos
    Route::get('/sedipranos', [PublicPanelController::class, 'sedipranos'])->name('public.sedipranos');
    Route::get('/sedipranos/crear', [PublicPanelController::class, 'createSediprano'])->name('public.sedipranos.create');
    Route::post('/sedipranos', [PublicPanelController::class, 'storeSediprano'])->name('public.sedipranos.store');
    Route::get('/sedipranos/{id}/editar', [PublicPanelController::class, 'editSediprano'])->name('public.sedipranos.edit');
    Route::put('/sedipranos/{id}', [PublicPanelController::class, 'updateSediprano'])->name('public.sedipranos.update');
    Route::delete('/sedipranos/{id}', [PublicPanelController::class, 'destroySediprano'])->name('public.sedipranos.destroy');
    Route::get('/sedipranos/{id}', [PublicPanelController::class, 'perfilSediprano'])->name('public.sedipranos.perfil');
    
    // CRUD de Eventos
    Route::get('/eventos', [PublicPanelController::class, 'eventos'])->name('public.eventos');
    Route::get('/eventos/crear', [PublicPanelController::class, 'createEvento'])->name('public.eventos.create');
    Route::post('/eventos', [PublicPanelController::class, 'storeEvento'])->name('public.eventos.store');
    Route::get('/eventos/{id}/editar', [PublicPanelController::class, 'editEvento'])->name('public.eventos.edit');
    Route::put('/eventos/{id}', [PublicPanelController::class, 'updateEvento'])->name('public.eventos.update');
    Route::delete('/eventos/{id}', [PublicPanelController::class, 'destroyEvento'])->name('public.eventos.destroy');
    
    // Gestión de Asistencias
    Route::get('/asistencias', [PublicPanelController::class, 'asistencias'])->name('public.asistencias');
    Route::get('/asistencias/evento/{eventoId}', [PublicPanelController::class, 'asistenciasPorEvento'])->name('public.asistencias.evento');
    Route::get('/tomar-asistencia/{eventoId}', [PublicPanelController::class, 'tomarAsistencia'])->name('public.tomar-asistencia');
    Route::post('/registrar-asistencia/{eventoId}', [PublicPanelController::class, 'registrarAsistencia'])->name('public.registrar-asistencia');
    Route::get('/escanear-qr', [PublicPanelController::class, 'escanearQR'])->name('public.escanear-qr');
    Route::post('/procesar-qr', [PublicPanelController::class, 'procesarQR'])->name('public.procesar-qr');
});
