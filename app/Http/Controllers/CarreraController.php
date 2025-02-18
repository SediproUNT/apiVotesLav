<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::all();
        return response()->json($carreras);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:carreras'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $carrera = Carrera::create($request->all());

        return response()->json([
            'message' => 'Carrera creada exitosamente',
            'data' => $carrera
        ], 201);
    }

    public function show($id)
    {
        $carrera = Carrera::find($id);

        if (!$carrera) {
            return response()->json([
                'message' => 'Carrera no encontrada'
            ], 404);
        }

        return response()->json($carrera);
    }

    public function update(Request $request, $id)
    {
        $carrera = Carrera::find($id);

        if (!$carrera) {
            return response()->json([
                'message' => 'Carrera no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:carreras,nombre,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $carrera->update($request->all());

        return response()->json([
            'message' => 'Carrera actualizada exitosamente',
            'data' => $carrera
        ]);
    }

    public function destroy($id)
    {
        $carrera = Carrera::find($id);

        if (!$carrera) {
            return response()->json([
                'message' => 'Carrera no encontrada'
            ], 404);
        }

        $carrera->delete();

        return response()->json([
            'message' => 'Carrera eliminada exitosamente'
        ]);
    }
}
