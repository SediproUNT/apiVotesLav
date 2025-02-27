<?php

namespace App\Http\Controllers;

use App\Models\Voto;
use App\Models\Votacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class VotoController extends Controller
{
    private function transformVoto($voto) {
        if ($voto->candidato) {
            $voto->candidato->sediprano->user_data = $voto->candidato->sediprano->user;
            $voto->candidato->sediprano->area_data = $voto->candidato->sediprano->area;
            $voto->candidato->sediprano->cargo_data = $voto->candidato->sediprano->cargo;
            unset(
                $voto->candidato->sediprano->user,
                $voto->candidato->sediprano->area,
                $voto->candidato->sediprano->cargo
            );
        }

        $voto->sediprano->user_data = $voto->sediprano->user;
        $voto->sediprano->area_data = $voto->sediprano->area;
        $voto->sediprano->cargo_data = $voto->sediprano->cargo;
        unset($voto->sediprano->user, $voto->sediprano->area, $voto->sediprano->cargo);

        return $voto;
    }

    public function index()
    {
        $votos = Voto::with([
            'sediprano.user',
            'sediprano.area',
            'sediprano.cargo',
            'candidato.sediprano.user',
            'candidato.sediprano.area',
            'candidato.sediprano.cargo',
            'votacion'
        ])
        ->get()
        ->map(function ($voto) {
            return $this->transformVoto($voto);
        });
        return response()->json($votos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sediprano_id' => 'required|exists:sedipranos,id',
            'votacion_id' => 'required|exists:votaciones,id',
            'es_blanco' => 'required|boolean',
            'candidato_id' => 'required_if:es_blanco,false|exists:candidatos,id'
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

        try {
            $voto = new Voto([
                'sediprano_id' => $request->sediprano_id,
                'votacion_id' => $request->votacion_id,
                'es_blanco' => $request->es_blanco,
                'candidato_id' => $request->es_blanco ? null : $request->candidato_id,
                'fecha_voto' => now()
            ]);

            $voto->save();
            $voto->load([
                'sediprano.user',
                'sediprano.area',
                'sediprano.cargo',
                'candidato.sediprano.user',
                'candidato.sediprano.area',
                'candidato.sediprano.cargo',
                'votacion'
            ]);

            return response()->json([
                'message' => 'Voto registrado exitosamente',
                'data' => $this->transformVoto($voto)
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error al registrar voto:', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al registrar el voto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $voto = Voto::with([
            'sediprano.user',
            'sediprano.area',
            'sediprano.cargo',
            'candidato.sediprano.user',
            'candidato.sediprano.area',
            'candidato.sediprano.cargo',
            'votacion'
        ])->find($id);

        if (!$voto) {
            return response()->json([
                'message' => 'Voto no encontrado'
            ], 404);
        }

        return response()->json($this->transformVoto($voto));
    }

    // No implementamos update porque los votos no deberían modificarse

    public function destroy($id)
    {
        try {
            $voto = Voto::with('votacion')->find($id);

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

        } catch (\Exception $e) {
            Log::error('Error al eliminar voto:', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al eliminar el voto'
            ], 500);
        }
    }
}
