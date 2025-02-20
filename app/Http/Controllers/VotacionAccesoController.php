<?php

namespace App\Http\Controllers;

use App\Models\Sediprano;
use App\Models\Votacion;
use App\Models\Voto;
use App\Models\Candidato;
use Illuminate\Http\Request;

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
        $votacion = Votacion::where('estado', 'pendiente')->first();

        if (!$votacion) {
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
        $request->validate([
            'sediprano_id' => 'required|exists:sedipranos,id',
            'votacion_id' => 'required|exists:votaciones,id',
            'voto_presidente_id' => 'required|exists:candidatos,id',
            'voto_director_id' => 'required|exists:candidatos,id'
        ]);

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

        // Registrar votos
        $votosARegistrar = [
            [
                'sediprano_id' => $request->sediprano_id,
                'candidato_id' => $request->voto_presidente_id,
                'votacion_id' => $request->votacion_id,
                'fecha_voto' => now()
            ],
            [
                'sediprano_id' => $request->sediprano_id,
                'candidato_id' => $request->voto_director_id,
                'votacion_id' => $request->votacion_id,
                'fecha_voto' => now()
            ]
        ];

        Voto::insert($votosARegistrar);

        return response()->json([
            'status' => 'success',
            'message' => 'Voto registrado exitosamente'
        ]);
    }
}
