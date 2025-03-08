<?php

namespace App\Http\Controllers;

use App\Models\Votacion;
use App\Enums\EstadoVotacion;
use Illuminate\Http\Request;

class VotacionPanelController extends Controller
{
    public function index()
    {
        $votaciones = Votacion::orderBy('fecha', 'desc')->paginate(10);
        return view('panel.votaciones.index', compact('votaciones'));
    }

    public function create()
    {
        return view('panel.votaciones.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'fecha' => 'required|date',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
                'descripcion' => 'nullable|string'
            ]);

            $votacion = Votacion::create([
                'name' => $validatedData['name'],
                'fecha' => $validatedData['fecha'],
                'hora_inicio' => $validatedData['hora_inicio'],
                'hora_fin' => $validatedData['hora_fin'],
                'descripcion' => $validatedData['descripcion'],
                'estado' => EstadoVotacion::Pendiente
            ]);

            return redirect()->route('panel.votaciones.index')
                ->with('success', 'Votación creada exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error creando votación: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Error al crear la votación: ' . $e->getMessage());
        }
    }

    public function edit($id) 
    {
        $votacion = Votacion::findOrFail($id);
        return view('panel.votaciones.edit', compact('votacion'));
    }

    public function update(Request $request, $id)
    {
        try {
            $votacion = Votacion::findOrFail($id);
            
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'fecha' => 'required|date',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
                'descripcion' => 'nullable|string',
                'estado' => 'required|string|in:' . implode(',', array_column(EstadoVotacion::cases(), 'value'))
            ]);

            $votacion->name = $validatedData['name'];
            $votacion->fecha = $validatedData['fecha'];
            $votacion->hora_inicio = $validatedData['hora_inicio'];
            $votacion->hora_fin = $validatedData['hora_fin'];
            $votacion->descripcion = $validatedData['descripcion'];
            $votacion->estado = EstadoVotacion::from($validatedData['estado']);
            
            $votacion->save();

            return redirect()->route('panel.votaciones.index')
                ->with('success', 'Votación actualizada exitosamente');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al actualizar la votación: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $votacion = Votacion::findOrFail($id);
            $votacion->delete();
            return redirect()->route('panel.votaciones.index')
                ->with('success', 'Votación eliminada exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la votación: ' . $e->getMessage());
        }
    }
}
