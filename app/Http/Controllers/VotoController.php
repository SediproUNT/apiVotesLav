<?php

namespace App\Http\Controllers;

use App\Models\Voto;
use App\Models\Votacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VotoController extends Controller
{
    public function index()
    {
        $votos = Voto::with(['sediprano', 'candidato', 'votacion'])->get();
        return response()->json($votos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sediprano_id' => 'required|exists:sedipranos,id',
            'candidato_id' => 'required|exists:candidatos,id',
            'votacion_id' => 'required|exists:votaciones,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verificar si la votación está activa
        $votacion = Votacion::find($request->votacion_id);
        if ($votacion->estado !== 'activa') {
            return response()->json([
                'status' => 'error',
                'message' => 'La votación no está activa'
            ], 400);
        }

        // Verificar si el sediprano ya votó en esta votación
        $votoExistente = Voto::where('sediprano_id', $request->sediprano_id)
            ->where('votacion_id', $request->votacion_id)
            ->first();

        if ($votoExistente) {
            return response()->json([
                'status' => 'error',
                'message' => 'El sediprano ya ha votado en esta votación'
            ], 400);
        }

        $voto = Voto::create($request->all());
        $voto->load(['sediprano', 'candidato', 'votacion']);

        return response()->json([
            'message' => 'Voto registrado exitosamente',
            'data' => $voto
        ], 201);
    }

    public function show($id)
    {
        $voto = Voto::with(['sediprano', 'candidato', 'votacion'])->find($id);

        if (!$voto) {
            return response()->json([
                'message' => 'Voto no encontrado'
            ], 404);
        }

        return response()->json($voto);
    }

    // No implementamos update porque los votos no deberían modificarse

    public function destroy($id)
    {
        $voto = Voto::find($id);

        if (!$voto) {
            return response()->json([
                'message' => 'Voto no encontrado'
            ], 404);
        }

        // Verificar si la votación está activa
        if ($voto->votacion->estado !== 'activa') {
            return response()->json([
                'status' => 'error',
                'message' => 'No se puede eliminar un voto de una votación finalizada'
            ], 400);
        }

        $voto->delete();

        return response()->json([
            'message' => 'Voto eliminado exitosamente'
        ]);
    }
}
