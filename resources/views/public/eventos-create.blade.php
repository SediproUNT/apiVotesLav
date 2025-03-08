@extends('layouts.public')

@section('title', 'Crear Evento')

@section('header-title', 'Crear Nuevo Evento')

@section('content')
<div class="mb-4">
    <a href="{{ route('public.eventos') }}" class="inline-flex items-center text-sm text-azul hover:text-azul-dark">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Volver a lista de eventos
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold text-azulOscuro mb-6">Registro de Nuevo Evento</h2>
    
    @if (session('error'))
        <div class="mb-4 bg-red-50 text-red-700 p-4 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('public.eventos.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Evento*</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                @error('nombre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3" 
                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Fecha*</label>
                <input type="date" name="fecha" id="fecha" value="{{ old('fecha', date('Y-m-d')) }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                @error('fecha')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="lugar" class="block text-sm font-medium text-gray-700 mb-1">Lugar</label>
                <input type="text" name="lugar" id="lugar" value="{{ old('lugar') }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20">
                @error('lugar')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="hora_inicio" class="block text-sm font-medium text-gray-700 mb-1">Hora de Inicio*</label>
                <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                @error('hora_inicio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="hora_fin" class="block text-sm font-medium text-gray-700 mb-1">Hora de Finalización*</label>
                <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin') }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                @error('hora_fin')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado*</label>
                <select name="estado" id="estado" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                    <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="en_curso" {{ old('estado') == 'en_curso' ? 'selected' : '' }}>En curso</option>
                    <option value="finalizado" {{ old('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                </select>
                @error('estado')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="button" onclick="window.location.href='{{ route('public.eventos') }}'" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md mr-2 hover:bg-gray-300">
                Cancelar
            </button>
            <button type="submit" class="px-4 py-2 bg-azul text-white rounded-md hover:bg-azul-dark">
                Crear Evento
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('hora_inicio').addEventListener('change', function() {
        const horaInicio = this.value;
        const horaFin = document.getElementById('hora_fin');
        
        // Si la hora de fin es anterior a la de inicio, se ajusta
        if (horaFin.value && horaFin.value <= horaInicio) {
            // Establecer la hora de fin 1 hora después de la de inicio
            const [horas, minutos] = horaInicio.split(':').map(Number);
            let nuevasHoras = horas + 1;
            if (nuevasHoras > 23) nuevasHoras = 23;
            horaFin.value = `${nuevasHoras.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}`;
        }
    });
</script>
@endpush
