<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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
}
