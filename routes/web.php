<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebVotacionController;

Route::get('/', function () {
    return redirect()->route('votacion.index');
});

Route::get('/votacion', [WebVotacionController::class, 'index'])->name('votacion.index');
Route::post('/votacion/validar', [WebVotacionController::class, 'validar'])->name('votacion.validar');
Route::get('/emitir-voto', [WebVotacionController::class, 'mostrarVotacion'])->name('votacion.emitir');
Route::post('/votacion/procesar', [WebVotacionController::class, 'procesarVoto'])->name('votacion.procesar');
