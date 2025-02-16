<?php

namespace App\Http\Controllers;

use App\Models\Voto;
use App\Models\Usuario;
use App\Models\Votacion;
use App\Models\Sediprano;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getStats()
    {
        // Estadísticas generales
        $totalVotos = Voto::count();
        $totalSedipranos = Sediprano::count();
        $votacionActiva = Votacion::where('estado', 'activa')->first();

        // Votos recientes con información del sediprano y candidato
        $recentVotos = Voto::with(['sediprano', 'candidato'])
            ->latest('fecha_voto')
            ->take(5)
            ->get();

        // Votos por día en la última semana
        $votosPorDia = Voto::select(DB::raw('DATE(fecha_voto) as fecha'), DB::raw('count(*) as total'))
            ->groupBy('fecha')
            ->orderBy('fecha', 'desc')
            ->take(7)
            ->get();

        // Asistencia del día actual
        $asistenciaHoy = Asistencia::where('fecha', date('Y-m-d'))
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN estado = \'presente\' THEN 1 ELSE 0 END) as presentes'),
                DB::raw('SUM(CASE WHEN estado = \'tardanza\' THEN 1 ELSE 0 END) as tardanzas'),
                DB::raw('SUM(CASE WHEN estado = \'falta\' THEN 1 ELSE 0 END) as faltas')
            )
            ->first();

        return response()->json([
            'estadisticas_generales' => [
                'total_votos' => $totalVotos,
                'total_sedipranos' => $totalSedipranos,
                'votacion_activa' => $votacionActiva,
            ],
            'votos_recientes' => $recentVotos,
            'votos_por_dia' => $votosPorDia,
            'asistencia_hoy' => $asistenciaHoy
        ]);
    }

    public function getParticipacionStats()
    {
        // Estadísticas de participación en votaciones actuales
        $votacionActual = Votacion::where('estado', 'activa')->first();

        if ($votacionActual) {
            $participacion = DB::table('sediprano as s')
                ->select(
                    DB::raw('COUNT(DISTINCT s.id) as total_sedipranos'),
                    DB::raw('COUNT(DISTINCT v.sediprano_id) as total_votantes'),
                    DB::raw('ROUND(COUNT(DISTINCT v.sediprano_id)::FLOAT / COUNT(DISTINCT s.id) * 100, 2) as porcentaje_participacion')
                )
                ->leftJoin('votos as v', function($join) use ($votacionActual) {
                    $join->on('s.id', '=', 'v.sediprano_id')
                         ->where('v.votacion_id', '=', $votacionActual->id);
                })
                ->first();

            return response()->json([
                'votacion_actual' => $votacionActual,
                'participacion' => $participacion
            ]);
        }

        return response()->json([
            'mensaje' => 'No hay votación activa en este momento'
        ]);
    }
}
