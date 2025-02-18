<?php

namespace App\Http\Controllers;

use App\Models\Votacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'estado' => 'required|in:pendiente,activa,finalizada'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $votacion = Votacion::create($request->all());

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
            'fecha' => 'date',
            'hora_inicio' => 'date_format:H:i',
            'hora_fin' => 'date_format:H:i|after:hora_inicio',
            'descripcion' => 'nullable|string',
            'estado' => 'in:pendiente,activa,finalizada'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $votacion->update($request->all());

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
}
