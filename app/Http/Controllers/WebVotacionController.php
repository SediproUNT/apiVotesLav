<?php

namespace App\Http\Controllers;

use App\Models\Sediprano;
use App\Models\Votacion;
use App\Models\Voto;
use App\Models\Candidato;
use App\Enums\EstadoVotacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class WebVotacionController extends Controller
{
    public function index()
    {
        return view('votacion.index');
    }

    public function validar(Request $request)
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

        if (!$votacion) {
            $proximaVotacion = Votacion::where('estado', EstadoVotacion::Pendiente)
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

        // Obtener candidatos
        $data = $this->obtenerCandidatos($votacion, $sediprano);

        // Guardar en sesión
        Session::put('votacion_data', [
            'sediprano' => $sediprano,
            'votacion' => $votacion,
            'candidatos' => $data
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Acceso validado',
            'redirect' => route('votacion.emitir')
        ]);
    }

    protected function obtenerCandidatos($votacion, $sediprano)
    {
        $candidatosPresidencia = Candidato::with(['sediprano.user', 'sediprano.area', 'sediprano.cargo'])
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
                    'area' => $candidato->sediprano->area->nombre ?? null,
                    'foto' => $candidato->foto
                ];
            });

        $candidatosArea = Candidato::with(['sediprano.user', 'sediprano.area', 'sediprano.cargo'])
            ->where('area_id', $sediprano->area_id)
            ->where('votacion_id', $votacion->id)
            ->whereHas('cargo', function ($q) {
                $q->where('nombre', 'Director');
            })
            ->get()
            ->map(function($candidato) {
                $area = $candidato->area->nombre ?? '';
                return [
                    'id' => $candidato->id,
                    'primer_apellido' => $candidato->sediprano->primer_apellido,
                    'segundo_apellido' => $candidato->sediprano->segundo_apellido,
                    'nombres' => $candidato->sediprano->user->name,
                    'cargo_actual' => $candidato->sediprano->cargo->nombre,
                    'postula_a' => "Director del Área de {$area}",
                    'area' => $area,
                    'foto' => $candidato->foto
                ];
            });

        return [
            'presidencia' => $candidatosPresidencia,
            'area' => $candidatosArea
        ];
    }

    public function mostrarVotacion()
    {
        $votacionData = Session::get('votacion_data');
        
        if (!$votacionData) {
            return redirect()->route('votacion.index')
                           ->with('error', 'Debe validar su acceso primero');
        }

        return view('votacion.emitir', ['data' => $votacionData]);
    }

    public function procesarVoto(Request $request)
    {
        try {
            $votacionData = Session::get('votacion_data');
            if (!$votacionData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sesión de votación no válida'
                ], 403);
            }

            // Validación básica
            if (!isset($request->votos) || count($request->votos) !== 2) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Formato de votos inválido'
                ], 422);
            }

            // Verificar si la votación está activa
            $ahora = now();
            $votacion = Votacion::where('id', $votacionData['votacion']['id'])
                ->where('estado', EstadoVotacion::Activa)
                ->where('fecha', $ahora->toDateString())
                ->where('hora_inicio', '<=', $ahora->format('H:i:s'))
                ->where('hora_fin', '>', $ahora->format('H:i:s'))
                ->first();

            if (!$votacion) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La votación no está activa en este momento'
                ], 400);
            }

            // Verificar si ya votó
            $yaVoto = Voto::where('sediprano_id', $votacionData['sediprano']['id'])
                ->where('votacion_id', $votacionData['votacion']['id'])
                ->exists();

            if ($yaVoto) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ya has emitido tu voto en esta votación'
                ], 400);
            }

            DB::transaction(function () use ($request, $votacionData) {
                foreach ($request->votos as $index => $voto) {
                    if (!$voto['es_blanco']) {
                        $candidato = Candidato::with('cargo')->find($voto['candidato_id']);

                        // Validar que el primer voto sea para presidente
                        if ($index === 0 && (!$candidato || $candidato->cargo->nombre !== 'Presidente')) {
                            throw new \Exception('El primer voto debe ser para un candidato a presidente');
                        }

                        // Validar que el segundo voto sea para director
                        if ($index === 1 && (!$candidato || $candidato->cargo->nombre !== 'Director')) {
                            throw new \Exception('El segundo voto debe ser para un candidato a director');
                        }
                    }

                    Voto::create([
                        'sediprano_id' => $votacionData['sediprano']['id'],
                        'votacion_id' => $votacionData['votacion']['id'],
                        'candidato_id' => $voto['es_blanco'] ? null : $voto['candidato_id'],
                        'es_blanco' => $voto['es_blanco'],
                        'fecha_voto' => now()
                    ]);
                }
            });

            // Limpiar la sesión después de votar exitosamente
            Session::forget('votacion_data');

            return response()->json([
                'status' => 'success',
                'message' => 'Votos registrados exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar el voto: ' . $e->getMessage()
            ], 500);
        }
    }
}
