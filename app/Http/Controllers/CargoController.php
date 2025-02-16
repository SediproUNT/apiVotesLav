<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CargoController extends Controller
{
    public function index()
    {
        $cargos = Cargo::all();
        return response()->json($cargos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:cargos',
            'descripcion' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $cargo = Cargo::create($request->all());

        return response()->json([
            'message' => 'Cargo creado exitosamente',
            'data' => $cargo
        ], 201);
    }

    public function show($id)
    {
        $cargo = Cargo::find($id);

        if (!$cargo) {
            return response()->json([
                'message' => 'Cargo no encontrado'
            ], 404);
        }

        return response()->json($cargo);
    }

    public function update(Request $request, $id)
    {
        $cargo = Cargo::find($id);

        if (!$cargo) {
            return response()->json([
                'message' => 'Cargo no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255|unique:cargos,nombre,' . $id,
            'descripcion' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $cargo->update($request->all());

        return response()->json([
            'message' => 'Cargo actualizado exitosamente',
            'data' => $cargo
        ]);
    }

    public function destroy($id)
    {
        $cargo = Cargo::find($id);

        if (!$cargo) {
            return response()->json([
                'message' => 'Cargo no encontrado'
            ], 404);
        }

        $cargo->delete();

        return response()->json([
            'message' => 'Cargo eliminado exitosamente'
        ]);
    }
}
