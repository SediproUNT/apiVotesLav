<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Sediprano;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class AsistenciaController extends Controller
{
    public function index()
    {
        $asistencias = Asistencia::with('sediprano')->get();
        return response()->json($asistencias);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sediprano_id' => 'required|exists:sedipranos,id',
            'fecha' => 'required|date',
            'hora_ingreso' => 'required|date_format:H:i',
            'estado' => 'required|in:presente,tardanza,falta',
            'participacion' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verificar si ya existe una asistencia para este sediprano en esta fecha
        $asistenciaExistente = Asistencia::where('sediprano_id', $request->sediprano_id)
            ->where('fecha', $request->fecha)
            ->first();

        if ($asistenciaExistente) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ya existe un registro de asistencia para este sediprano en esta fecha'
            ], 400);
        }

        $asistencia = Asistencia::create($request->all());
        $asistencia->load('sediprano');

        return response()->json([
            'message' => 'Asistencia registrada exitosamente',
            'data' => $asistencia
        ], 201);
    }

    public function show($id)
    {
        $asistencia = Asistencia::with('sediprano')->find($id);

        if (!$asistencia) {
            return response()->json([
                'message' => 'Asistencia no encontrada'
            ], 404);
        }

        return response()->json($asistencia);
    }

    public function update(Request $request, $id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia) {
            return response()->json([
                'message' => 'Asistencia no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'sediprano_id' => 'exists:sedipranos,id',
            'fecha' => 'date',
            'hora_ingreso' => 'date_format:H:i',
            'estado' => 'in:presente,tardanza,falta',
            'participacion' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $asistencia->update($request->all());
        $asistencia->load('sediprano');

        return response()->json([
            'message' => 'Asistencia actualizada exitosamente',
            'data' => $asistencia
        ]);
    }

    public function destroy($id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia) {
            return response()->json([
                'message' => 'Asistencia no encontrada'
            ], 404);
        }

        $asistencia->delete();

        return response()->json([
            'message' => 'Asistencia eliminada exitosamente'
        ]);
    }

    public function porFecha($fecha)
    {
        $asistencias = Asistencia::with('sediprano')
            ->where('fecha', $fecha)
            ->get();

        return response()->json($asistencias);
    }

    public function porSediprano($sedipranoId)
    {
        $asistencias = Asistencia::with('sediprano')
            ->where('sediprano_id', $sedipranoId)
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json($asistencias);
    }

    public function registrarAsistencia(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
            'evento_id' => 'required|exists:eventos,id'
        ]);

        // Buscar el sediprano por el código QR
        $sediprano = Sediprano::where('qr_code', $request->qr_code)->first();
        if (!$sediprano) {
            return response()->json([
                'status' => 'error',
                'message' => 'Código QR no válido'
            ], 404);
        }

        // Verificar si el evento está activo
        $evento = Evento::findOrFail($request->evento_id);
        if ($evento->estado !== 'en_curso') {
            return response()->json([
                'status' => 'error',
                'message' => 'El evento no está activo'
            ], 400);
        }

        // Verificar si ya existe una asistencia
        $asistenciaExistente = Asistencia::where('evento_id', $evento->id)
            ->where('sediprano_id', $sediprano->id)
            ->first();

        if ($asistenciaExistente) {
            return response()->json([
                'status' => 'error',
                'message' => 'La asistencia ya fue registrada'
            ], 400);
        }

        // Determinar el estado de la asistencia
        $horaRegistro = Carbon::now();
        $horaInicio = Carbon::parse($evento->fecha . ' ' . $evento->hora_inicio);
        $tolerancia = 15; // minutos de tolerancia

        $estado = $horaRegistro->diffInMinutes($horaInicio) <= $tolerancia
            ? 'presente'
            : 'tardanza';

        // Registrar asistencia
        $asistencia = Asistencia::create([
            'evento_id' => $evento->id,
            'sediprano_id' => $sediprano->id,
            'hora_registro' => $horaRegistro,
            'estado' => $estado
        ]);

        return response()->json([
            'message' => 'Asistencia registrada exitosamente',
            'data' => $asistencia->load('sediprano')
        ], 201);
    }
}
