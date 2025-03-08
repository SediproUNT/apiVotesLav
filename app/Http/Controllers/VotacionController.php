<?php

namespace App\Http\Controllers;

use App\Models\Votacion;
use App\Enums\EstadoVotacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class VotacionController extends Controller
{
    public function index()
    {
        $votaciones = Votacion::with('votos')->get();
        return response()->json($votaciones);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'descripcion' => 'nullable|string',
            'estado' => ['required', new Enum(EstadoVotacion::class)]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $votacion = Votacion::create([
            ...$request->except('estado'),
            'estado' => EstadoVotacion::from($request->estado)
        ]);

        return response()->json([
            'message' => 'Votación creada exitosamente',
            'data' => $votacion
        ], 201);
    }

    public function show($id)
    {
        $votacion = Votacion::with('votos')->find($id);

        if (!$votacion) {
            return response()->json([
                'message' => 'Votación no encontrada'
            ], 404);
        }

        return response()->json($votacion);
    }

    public function update(Request $request, $id)
    {
        $votacion = Votacion::find($id);

        if (!$votacion) {
            return response()->json([
                'message' => 'Votación no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'fecha' => 'sometimes|date',
            'hora_inicio' => 'sometimes|date_format:H:i',
            'hora_fin' => 'sometimes|date_format:H:i|after:hora_inicio',
            'descripcion' => 'nullable|string',
            'estado' => ['sometimes', new Enum(EstadoVotacion::class)]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = $request->except('estado');
        if ($request->has('estado')) {
            $updateData['estado'] = EstadoVotacion::from($request->estado);
        }

        $votacion->update($updateData);

        return response()->json([
            'message' => 'Votación actualizada exitosamente',
            'data' => $votacion
        ]);
    }

    public function destroy($id)
    {
        $votacion = Votacion::find($id);

        if (!$votacion) {
            return response()->json([
                'message' => 'Votación no encontrada'
            ], 404);
        }

        $votacion->delete();

        return response()->json([
            'message' => 'Votación eliminada exitosamente'
        ]);
    }

    /**
     * Obtiene el estado actual de las votaciones para el frontend
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEstadoVotaciones()
    {
        try {
            $ahora = now();
            
            // Buscar votación activa en este momento
            $votacionActiva = Votacion::where(function($query) use ($ahora) {
                $query->where('fecha', $ahora->toDateString())
                      ->where('hora_inicio', '<=', $ahora->format('H:i:s'))
                      ->where('hora_fin', '>', $ahora->format('H:i:s'));
            })->first();

            if ($votacionActiva) {
                // Forzar actualización del estado
                $votacionActiva->actualizarEstadoAutomatico();
                $votacionActiva->refresh();
                
                return response()->json([
                    'status' => 'success',
                    'hayVotacionActiva' => true,
                    'votacion' => [
                        'id' => $votacionActiva->id,
                        'nombre' => $votacionActiva->name,
                        'estado' => $votacionActiva->estado,
                        'fecha' => $votacionActiva->fecha,
                        'hora_inicio' => $votacionActiva->hora_inicio,
                        'hora_fin' => $votacionActiva->hora_fin,
                        'descripcion' => $votacionActiva->descripcion
                    ]
                ]);
            }

            // Si no hay votación activa, buscar la próxima
            $proximaVotacion = Votacion::where('estado', EstadoVotacion::Pendiente)
                ->where(function($query) use ($ahora) {
                    $query->where('fecha', '>', $ahora->toDateString())
                        ->orWhere(function($q) use ($ahora) {
                            $q->where('fecha', $ahora->toDateString())
                                ->where('hora_inicio', '>', $ahora->format('H:i:s'));
                        });
                })
                ->orderBy('fecha')
                ->orderBy('hora_inicio')
                ->first();

            if ($proximaVotacion) {
                return response()->json([
                    'status' => 'success',
                    'hayVotacionActiva' => false,
                    'proximaVotacion' => [
                        'id' => $proximaVotacion->id,
                        'nombre' => $proximaVotacion->name,
                        'estado' => $proximaVotacion->estado,
                        'fecha' => $proximaVotacion->fecha,
                        'hora_inicio' => $proximaVotacion->hora_inicio,
                        'mensaje' => "La votación comenzará el {$proximaVotacion->fecha} a las {$proximaVotacion->hora_inicio}"
                    ]
                ]);
            }

            // No hay votación activa ni próxima
            return response()->json([
                'status' => 'success',
                'hayVotacionActiva' => false,
                'mensaje' => 'No hay votaciones programadas en este momento.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener el estado de las votaciones: ' . $e->getMessage()
            ], 500);
        }
    }
}
