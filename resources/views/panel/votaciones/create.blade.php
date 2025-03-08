@extends('layouts.public')

@section('title', 'Nueva Votación')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-azulOscuro">Nueva Votación</h2>
    </div>

    <form action="{{ route('panel.votaciones.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Votación</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">
            </div>

            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                <input type="date" name="fecha" id="fecha" value="{{ old('fecha') }}" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora de Inicio</label>
                    <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}" required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">
                </div>

                <div>
                    <label for="hora_fin" class="block text-sm font-medium text-gray-700">Hora de Fin</label>
                    <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin') }}" required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">
                </div>
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">{{ old('descripcion') }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('panel.votaciones.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-azul border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-azul-dark">
                Crear Votación
            </button>
        </div>
    </form>
</div>
@endsection
