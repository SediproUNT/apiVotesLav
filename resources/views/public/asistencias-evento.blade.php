@extends('layouts.public')

@section('title', 'Asistencias por Evento')

@section('header-title', 'Asistencias: ' . $evento->nombre)

@section('content')
<div class="mb-6">
    <a href="{{ route('public.asistencias') }}" class="inline-flex items-center text-sm text-azul hover:text-azul-dark">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Volver a asistencias
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="grid md:grid-cols-4 gap-6">
        <div>
            <h3 class="text-sm font-medium text-gray-500">Evento</h3>
            <p class="text-lg font-semibold text-gray-900">{{ $evento->nombre }}</p>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-500">Fecha</h3>
            <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</p>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-500">Horario</h3>
            <p class="text-lg font-semibold text-gray-900">{{ $evento->hora_inicio }} - {{ $evento->hora_fin }}</p>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-500">Lugar</h3>
            <p class="text-lg font-semibold text-gray-900">{{ $evento->lugar ?? 'No especificado' }}</p>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-500">Estado</h3>
            <p class="inline-flex items-center">
                @if($evento->estado == 'en_curso')
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        En curso
                    </span>
                @elseif($evento->estado == 'pendiente')
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        Pendiente
                    </span>
                @elseif($evento->estado == 'finalizado')
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                        Finalizado
                    </span>
                @endif
            </p>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-500">Total Asistentes</h3>
            <p class="text-lg font-semibold text-gray-900">{{ $asistencias->count() }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-azulOscuro">Listado de Asistencias</h2>
        
        <div class="relative">
            <input type="text" id="buscarAsistencia" placeholder="Buscar por nombre o código..." 
                   class="w-full md:w-64 pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-azul">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Sediprano
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Código
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Área
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Hora
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Estado
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($asistencias as $asistencia)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-azulOscuro/10 flex items-center justify-center text-azulOscuro font-bold">
                                    {{ substr($asistencia->sediprano->user->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $asistencia->sediprano->user->name }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $asistencia->sediprano->codigo }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $asistencia->sediprano->area ? $asistencia->sediprano->area->nombre : 'Sin área' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($asistencia->hora_registro)->format('H:i:s') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($asistencia->estado == 'presente')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Presente
                            </span>
                        @elseif($asistencia->estado == 'tardanza')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Tardanza
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Falta
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                        No hay registros de asistencia para este evento
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Sección de estadísticas -->
    @if($asistencias->count() > 0)
    <div class="mt-8 pt-6 border-t border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Estadísticas de asistencia</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-green-50 border border-green-100 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-800">Presentes</p>
                        <p class="text-2xl font-bold text-green-600">
                            {{ $asistencias->where('estado', 'presente')->count() }}
                        </p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-green-700">
                    {{ number_format(($asistencias->where('estado', 'presente')->count() / $asistencias->count() * 100), 1) }}% del total
                </div>
            </div>
            
            <div class="bg-yellow-50 border border-yellow-100 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-yellow-800">Tardanzas</p>
                        <p class="text-2xl font-bold text-yellow-600">
                            {{ $asistencias->where('estado', 'tardanza')->count() }}
                        </p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-yellow-700">
                    {{ number_format(($asistencias->where('estado', 'tardanza')->count() / $asistencias->count() * 100), 1) }}% del total
                </div>
            </div>
            
            <div class="bg-red-50 border border-red-100 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-red-800">Faltas</p>
                        <p class="text-2xl font-bold text-red-600">
                            {{ $asistencias->where('estado', 'falta')->count() }}
                        </p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-red-700">
                    {{ number_format(($asistencias->where('estado', 'falta')->count() / $asistencias->count() * 100), 1) }}% del total
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    // Búsqueda en la tabla de asistencias
    document.getElementById('buscarAsistencia').addEventListener('keyup', function() {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(input) ? '' : 'none';
        });
    });
</script>
@endpush
