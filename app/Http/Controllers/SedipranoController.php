<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sediprano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SedipranoController extends Controller
{
    public function index()
    {
        $sedipranos = Sediprano::with('user')->get();
        return response()->json($sedipranos);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'codigo' => 'required|numeric|unique:sedipranos', // Cambiado de integer a numeric
                'dni' => 'nullable|string|size:8',
                'primer_apellido' => 'required|string|max:255',
                'segundo_apellido' => 'required|string|max:255',
                'carrera' => 'nullable|string|max:255',
                'celular' => 'nullable|string|size:9',
                'fecha_nacimiento' => 'nullable|date_format:d/m/Y',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Convertir el formato de fecha
            $fechaNacimiento = $request->fecha_nacimiento ?
                \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->format('Y-m-d') :
                null;

            // Crear usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->codigo)
            ]);

            // Crear sediprano
            $sediprano = Sediprano::create([
                'codigo' => $request->codigo,
                'dni' => $request->dni,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'carrera' => $request->carrera,
                'celular' => $request->celular,
                'fecha_nacimiento' => $fechaNacimiento,
                'user_id' => $user->id
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Sediprano creado exitosamente. La contraseña es el código: ' . $request->codigo,
                'data' => [
                    'sediprano' => $sediprano,
                    'user' => $user
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear el sediprano',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $sediprano = Sediprano::with('user')->find($id);
        if (!$sediprano) {
            return response()->json([
                'message' => 'Sediprano no encontrado'
            ], 404);
        }
        return response()->json($sediprano);
    }

    public function update(Request $request, $id)
    {
        $sediprano = Sediprano::find($id);
        if (!$sediprano) {
            return response()->json([
                'message' => 'Sediprano no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'codigo' => 'integer|unique:sediprano,codigo,' . $id,
            'dni' => 'nullable|string|size:8',
            'primer_apellido' => 'string|max:255',
            'segundo_apellido' => 'string|max:255',
            'carrera' => 'nullable|string|max:255',
            'celular' => 'nullable|string|size:9',
            'fecha_nacimiento' => 'nullable|date',
            'user_id' => 'integer|unique:sediprano,user_id,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $sediprano->update($request->all());
        return response()->json([
            'message' => 'Sediprano actualizado exitosamente',
            'data' => $sediprano
        ]);
    }

    public function destroy($id)
    {
        $sediprano = Sediprano::find($id);
        if (!$sediprano) {
            return response()->json([
                'message' => 'Sediprano no encontrado'
            ], 404);
        }

        $sediprano->delete();
        return response()->json([
            'message' => 'Sediprano eliminado exitosamente'
        ]);
    }
}
