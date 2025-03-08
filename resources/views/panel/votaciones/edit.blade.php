@extends('layouts.public')

@section('title', 'Editar Votación')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-azulOscuro">Editar Votación</h2>
    </div>

    <form action="{{ route('panel.votaciones.update', $votacion->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Votación</label>
                <input type="text" name="name" id="name" value="{{ old('name', $votacion->name) }}" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">
            </div>

            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                <input type="date" name="fecha" id="fecha" value="{{ old('fecha', $votacion->fecha) }}" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora de Inicio</label>
                    <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio', substr($votacion->hora_inicio, 0, 5)) }}" required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">
                </div>

                <div>
                    <label for="hora_fin" class="block text-sm font-medium text-gray-700">Hora de Fin</label>
                    <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin', substr($votacion->hora_fin, 0, 5)) }}" required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">
                </div>
            </div>

            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                <select name="estado" id="estado" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">
                    @foreach (App\Enums\EstadoVotacion::cases() as $estado)
                        <option value="{{ $estado->value }}" {{ $votacion->estado == $estado ? 'selected' : '' }}>
                            {{ ucfirst($estado->value) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">{{ old('descripcion', $votacion->descripcion) }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('panel.votaciones.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-azul border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-azul-dark">
                Actualizar Votación
            </button>
        </div>
    </form>
</div>
@endsection
