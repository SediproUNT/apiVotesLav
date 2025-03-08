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
}
