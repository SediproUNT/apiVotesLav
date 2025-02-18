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
        $sedipranos = Sediprano::with(['user', 'carrera', 'cargo', 'area'])->get();
        return response()->json($sedipranos);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'codigo' => 'required|numeric|unique:sedipranos',
                'dni' => 'nullable|string|size:8',
                'primer_apellido' => 'required|string|max:255',
                'segundo_apellido' => 'required|string|max:255',
                'carrera_id' => 'required|exists:carreras,id',
                'cargo_id' => 'required|exists:cargos,id',
                'area_id' => 'nullable|exists:areas,id',
                'genero' => 'required|string',
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

            // Crear sediprano con los campos actualizados
            $sediprano = Sediprano::create([
                'codigo' => $request->codigo,
                'dni' => $request->dni,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'carrera_id' => $request->carrera_id,
                'genero' => $request->genero,
                'cargo_id' => $request->cargo_id,
                'area_id' => $request->area_id,
                'celular' => $request->celular,
                'fecha_nacimiento' => $fechaNacimiento,
                'user_id' => $user->id
            ]);

            // Cargar las relaciones
            $sediprano->load(['user', 'carrera', 'cargo', 'area']);

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
        $sediprano = Sediprano::with(['user', 'carrera', 'cargo', 'area'])->find($id);
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
            'codigo' => 'numeric|unique:sedipranos,codigo,' . $id,
            'dni' => 'nullable|string|size:8',
            'primer_apellido' => 'string|max:255',
            'segundo_apellido' => 'string|max:255',
            'carrera_id' => 'exists:carreras,id',
            'cargo_id' => 'exists:cargos,id',
            'area_id' => 'nullable|exists:areas,id',
            'genero' => 'string',
            'celular' => 'nullable|string|size:9',
            'fecha_nacimiento' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $sediprano->update($request->all());
        $sediprano->load(['user', 'carrera', 'cargo', 'area']);
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
