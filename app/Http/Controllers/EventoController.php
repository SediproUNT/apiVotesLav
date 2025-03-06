<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::with('asistencias')->get();
        return response()->json($eventos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
            'ubicacion' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $evento = Evento::create($request->all());
        return response()->json([
            'message' => 'Evento creado exitosamente',
            'data' => $evento
        ], 201);
    }

    public function show($id)
    {
        $evento = Evento::with('asistencias')->find($id);

        if (!$evento) {
            return response()->json([
                'status' => 'error',
                'message' => 'Evento no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $evento
        ]);
    }

    public function update(Request $request, $id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json([
                'status' => 'error',
                'message' => 'Evento no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'descripcion' => 'string',
            'fecha' => 'date',
            'hora_inicio' => 'string',
            'hora_fin' => 'after:hora_inicio',
            'ubicacion' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $evento->update($request->all());
        return response()->json([
            'message' => 'Evento actualizado exitosamente',
            'data' => $evento
        ]);
    }

    public function destroy($id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json([
                'status' => 'error',
                'message' => 'Evento no encontrado'
            ], 404);
        }

        $evento->delete();
        return response()->json([
            'message' => 'Evento eliminado exitosamente'
        ]);
    }

    /**
     * Obtener eventos disponibles actuales y próximos
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventosDisponibles()
    {
        $ahora = Carbon::now();
        
        // Obtener todos los eventos relevantes
        $eventos = Evento::where(function($query) use ($ahora) {
            // Eventos en curso para cualquier fecha
            $query->where('estado', 'en_curso')
                // O eventos próximos (sin importar el estado)
                ->orWhere(function($q) use ($ahora) {
                    $q->where('fecha', '>=', $ahora->toDateString());
                });
        })
        ->orderBy('fecha')
        ->orderBy('hora_inicio')
        ->get();

        // Categorizar los eventos
        $eventosActuales = $eventos->filter(function($evento) use ($ahora) {
            if ($evento->estado !== 'en_curso') {
                return false;
            }
            
            $fechaEvento = Carbon::parse($evento->fecha);
            $inicioEvento = Carbon::parse($evento->fecha . ' ' . $evento->hora_inicio);
            $finEvento = Carbon::parse($evento->fecha . ' ' . $evento->hora_fin);
            
            // Si la hora de fin es menor que la hora de inicio, significa que termina al día siguiente
            if ($finEvento->lt($inicioEvento)) {
                $finEvento->addDay();
            }
            
            return $ahora->between($inicioEvento, $finEvento);
        });

        $eventosProximos = $eventos->filter(function($evento) use ($ahora) {
            $fechaEvento = Carbon::parse($evento->fecha);
            $inicioEvento = Carbon::parse($evento->fecha . ' ' . $evento->hora_inicio);
            
            // Eventos que aún no han comenzado
            return $ahora->lt($inicioEvento);
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'fecha_actual' => $ahora->toDateTimeString(),
                'eventos_actuales' => $eventosActuales->values(),
                'eventos_proximos' => $eventosProximos->values(),
                'todos_los_eventos' => $eventos
            ]
        ]);
    }
}
