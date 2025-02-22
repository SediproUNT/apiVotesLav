<?php

namespace App\Http\Controllers;

use App\Models\Sediprano;
use App\Models\Votacion;
use App\Models\Voto;
use App\Models\Candidato;
use App\Enums\EstadoVotacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VotacionAccesoController extends Controller
{
    public function validarAcceso(Request $request)
    {
        $request->validate([
            'codigo' => 'required|numeric',
            'dni' => 'required|string|size:8'
        ]);


        // Buscar sediprano
        $sediprano = Sediprano::with(['user', 'area', 'cargo'])
            ->where('codigo', $request->codigo)
            ->where('dni', $request->dni)
            ->first();

        if (!$sediprano) {
            return response()->json([
                'status' => 'error',
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        // Buscar votación activa
        $ahora = now();
        $votacion = Votacion::where(function($query) use ($ahora) {
            $query->where('fecha', $ahora->toDateString())
                  ->where('hora_inicio', '<=', $ahora->format('H:i:s'))
                  ->where('hora_fin', '>', $ahora->format('H:i:s'));
        })->first();

        if ($votacion) {
            // Forzar actualización del estado
            $votacion->actualizarEstadoAutomatico();
            $votacion->refresh();
        }

        if (!$votacion) {
            // Buscar próxima votación para mostrar mensaje informativo
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
                    'status' => 'error',
                    'message' => "La votación comenzará el {$proximaVotacion->fecha} a las {$proximaVotacion->hora_inicio}"
                ], 404);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'No hay votación activa en este momento'
            ], 404);
        }

        // Verificar si ya votó
        $yaVoto = Voto::where('sediprano_id', $sediprano->id)
            ->where('votacion_id', $votacion->id)
            ->exists();

        if ($yaVoto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ya has emitido tu voto en esta votación'
            ], 400);
        }

        // Obtener candidatos con información completa y formateada
        $candidatosPresidencia = Candidato::with([
            'sediprano' => function($query) {
                $query->with(['user', 'area', 'cargo']);
            },
            'cargo',
            'area'
        ])
        ->whereHas('cargo', function ($q) {
            $q->where('nombre', 'Presidente');
        })
        ->where('votacion_id', $votacion->id)
        ->get()
        ->map(function($candidato) {
            return [
                'id' => $candidato->id,
                'primer_apellido' => $candidato->sediprano->primer_apellido,
                'segundo_apellido' => $candidato->sediprano->segundo_apellido,
                'nombres' => $candidato->sediprano->user->name,
                'cargo_actual' => $candidato->sediprano->cargo->nombre,
                'postula_a' => 'Presidente de SEDIPRO',
                'area' => $candidato->sediprano->area ? $candidato->sediprano->area->nombre : null,
                'foto' => $candidato->foto,
                'selected' => false
            ];
        });

        $candidatosArea = Candidato::with([
            'sediprano' => function($query) {
                $query->with(['user', 'area', 'cargo']);
            },
            'cargo',
            'area'
        ])
        ->where('area_id', $sediprano->area_id)
        ->where('votacion_id', $votacion->id)
        ->whereHas('cargo', function ($q) {
            $q->where('nombre', 'Director');
        })
        ->get()
        ->map(function($candidato) {
            $area = $candidato->area ? $candidato->area->nombre : '';
            return [
                'id' => $candidato->id,
                'primer_apellido' => $candidato->sediprano->primer_apellido,
                'segundo_apellido' => $candidato->sediprano->segundo_apellido,
                'nombres' => $candidato->sediprano->user->name,
                'cargo_actual' => $candidato->sediprano->cargo->nombre,
                'postula_a' => "Director del Área de {$area}",
                'area' => $area,
                'foto' => $candidato->foto,
                'selected' => false
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Acceso validado',
            'data' => [
                'sediprano' => $sediprano,
                'votacion' => $votacion,
                'candidatos' => [
                    'presidencia' => $candidatosPresidencia,
                    'area' => $candidatosArea
                ]
            ]
        ]);
    }

    public function emitirVoto(Request $request)
    {
        // Validación básica
        $validator = Validator::make($request->all(), [
            'sediprano_id' => 'required|exists:sedipranos,id',
            'votacion_id' => 'required|exists:votaciones,id',
            'votos' => 'required|array|size:2',
            'votos.*.es_blanco' => 'required|boolean',
            'votos.*.candidato_id' => [
                'required_if:votos.*.es_blanco,false',
                'nullable',
                'exists:candidatos,id'
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verificar si la votación está activa y dentro del horario
        $ahora = now();
        $votacion = Votacion::where('id', $request->votacion_id)
            ->where('estado', EstadoVotacion::Activa)
            ->where('fecha', $ahora->toDateString())
            ->where('hora_inicio', '<=', $ahora->format('H:i:s'))
            ->where('hora_fin', '>', $ahora->format('H:i:s'))
            ->first();

        if (!$votacion) {
            return response()->json([
                'status' => 'error',
                'message' => 'La votación no está activa en este momento o está fuera del horario establecido'
            ], 400);
        }

        // Verificar si ya votó
        $yaVoto = Voto::where('sediprano_id', $request->sediprano_id)
            ->where('votacion_id', $request->votacion_id)
            ->exists();

        if ($yaVoto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ya has emitido tu voto en esta votación'
            ], 400);
        }

        try {
            DB::transaction(function () use ($request) {
                // Verificar que los candidatos correspondan a los cargos correctos
                foreach ($request->votos as $index => $voto) {
                    if (!$voto['es_blanco']) {
                        $candidato = Candidato::with('cargo')->find($voto['candidato_id']);

                        // Validar que el primer voto sea para presidente
                        if ($index === 0 && (!$candidato || $candidato->cargo->nombre !== 'Presidente')) {
                            throw new \Exception('El primer voto debe ser para un candidato a presidente');
                        }

                        // Validar que el segundo voto sea para director de área
                        if ($index === 1 && (!$candidato || $candidato->cargo->nombre !== 'Director')) {
                            throw new \Exception('El segundo voto debe ser para un candidato a director');
                        }
                    }

                    Voto::create([
                        'sediprano_id' => $request->sediprano_id,
                        'votacion_id' => $request->votacion_id,
                        'candidato_id' => $voto['es_blanco'] ? null : $voto['candidato_id'],
                        'es_blanco' => $voto['es_blanco'],
                        'fecha_voto' => now()
                    ]);
                }
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Votos registrados exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al registrar los votos: ' . $e->getMessage()
            ], 500);
        }
    }
}
