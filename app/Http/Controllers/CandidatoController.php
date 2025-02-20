<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CandidatoController extends Controller
{
    public function index()
    {
        try {
            $candidatos = Candidato::with([
                'sediprano.user',
                'sediprano.area',
                'cargo',
                'area',
                'votacion'
            ])->get();

            Log::info('Candidatos cargados con relaciones:', [
                'count' => $candidatos->count(),
                'sample' => $candidatos->first()
            ]);

            return response()->json($candidatos);
        } catch (\Exception $e) {
            Log::error('Error cargando candidatos:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Error al cargar los candidatos'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sediprano_id' => 'required|exists:sedipranos,id|unique:candidatos',
            'cargo_id' => 'required|exists:cargos,id',
            'area_id' => 'nullable|exists:areas,id',
            'votacion_id' => 'required|exists:votaciones,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();

            // Procesar la foto si se subió una
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $nombreFoto = time() . '_' . $foto->getClientOriginalName();
                $foto->storeAs('public/candidatos', $nombreFoto);
                $data['foto'] = 'candidatos/' . $nombreFoto;
            }

            $candidato = Candidato::create($data);
            $candidato->load([
                'sediprano.user',
                'sediprano.area',
                'cargo',
                'area',
                'votacion'
            ]);

            return response()->json([
                'message' => 'Candidato creado exitosamente',
                'data' => $candidato
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creando candidato:', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear el candidato',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $candidato = Candidato::with([
            'sediprano.user',
            'sediprano.area',
            'cargo',
            'area',
            'votacion'
        ])->find($id);

        if (!$candidato) {
            return response()->json([
                'message' => 'Candidato no encontrado'
            ], 404);
        }

        return response()->json($candidato);
    }

    public function update(Request $request, $id)
    {
        $candidato = Candidato::find($id);

        if (!$candidato) {
            return response()->json([
                'message' => 'Candidato no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'sediprano_id' => 'exists:sedipranos,id|unique:candidatos,sediprano_id,' . $id,
            'cargo_id' => 'exists:cargos,id',
            'area_id' => 'nullable|exists:areas,id',
            'votacion_id' => 'required|exists:votaciones,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();

            // Procesar la foto si se subió una nueva
            if ($request->hasFile('foto')) {
                // Eliminar la foto anterior si existe
                if ($candidato->foto) {
                    Storage::delete('public/' . $candidato->foto);
                }

                $foto = $request->file('foto');
                $nombreFoto = time() . '_' . $foto->getClientOriginalName();
                $foto->storeAs('public/candidatos', $nombreFoto);
                $data['foto'] = 'candidatos/' . $nombreFoto;
            }

            $candidato->update($data);
            $candidato->load([
                'sediprano.user',
                'sediprano.area',
                'cargo',
                'area',
                'votacion'
            ]);

            return response()->json([
                'message' => 'Candidato actualizado exitosamente',
                'data' => $candidato
            ]);
        } catch (\Exception $e) {
            Log::error('Error actualizando candidato:', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar el candidato',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $candidato = Candidato::find($id);

        if (!$candidato) {
            return response()->json([
                'message' => 'Candidato no encontrado'
            ], 404);
        }

        // Eliminar la foto si existe
        if ($candidato->foto) {
            Storage::delete('public/' . $candidato->foto);
        }

        $candidato->delete();

        return response()->json([
            'message' => 'Candidato eliminado exitosamente'
        ]);
    }
}
