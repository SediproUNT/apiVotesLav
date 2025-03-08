@extends('layouts.public')

@section('title', 'Tomar Asistencia')

@section('header-title', 'Registro de Asistencia: ' . $evento->nombre)

@section('content')
<div class="mb-4">
    <a href="{{ route('public.eventos') }}" class="inline-flex items-center text-sm text-azul hover:text-azul-dark">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Volver a eventos
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
    </div>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold text-azulOscuro mb-6">Registro de Asistencias</h2>
    
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded-md p-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-md p-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <div>
            <a href="{{ route('public.escanear-qr') }}" class="inline-flex items-center px-4 py-2 bg-morado text-white rounded-md hover:bg-morado-dark">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                Escanear QR
            </a>
        </div>
        
        <div class="relative">
            <input type="text" id="buscarSediprano" placeholder="Buscar por nombre o código..." 
                   class="w-full md:w-64 pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-azul">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    <form action="{{ route('public.registrar-asistencia', $evento->id) }}" method="POST">
        @csrf
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Código
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sediprano
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Área
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Observación
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($sedipranos as $sediprano)
                    <tr class="sediprano-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $sediprano->codigo }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-azulOscuro/10 flex items-center justify-center text-azulOscuro font-bold">
                                        {{ substr($sediprano->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $sediprano->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $sediprano->dni }}</div>
                                </div>
                            </div>
                            <input type="hidden" name="asistencias[{{ $sediprano->id }}][sediprano_id]" value="{{ $sediprano->id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $sediprano->area->nombre ?? 'Sin área' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select name="asistencias[{{ $sediprano->id }}][estado]" 
                                    class="border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20 text-sm w-full">
                                <option value="presente" {{ in_array($sediprano->id, $asistenciasRegistradas) ? 'selected' : '' }}>Presente</option>
                                <option value="tardanza">Tardanza</option>
                                <option value="falta" {{ !in_array($sediprano->id, $asistenciasRegistradas) ? 'selected' : '' }}>Falta</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="text" name="asistencias[{{ $sediprano->id }}][observacion]" 
                                   class="border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20 text-sm w-full"
                                   placeholder="Observación">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" onclick="marcarTodos('presente')" 
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                Todos Presentes
            </button>
            <button type="button" onclick="marcarTodos('falta')" 
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                Todos Faltas
            </button>
            <button type="submit" class="px-4 py-2 bg-azul text-white rounded-md hover:bg-azul-dark">
                Guardar Asistencias
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Función para marcar todos los estados
    function marcarTodos(estado) {
        const selects = document.querySelectorAll('select[name^="asistencias"]');
        selects.forEach(select => {
            select.value = estado;
        });
    }
    
    // Búsqueda en la tabla
    document.getElementById('buscarSediprano').addEventListener('keyup', function() {
        const term = this.value.toLowerCase();
        const rows = document.querySelectorAll('.sediprano-row');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    });
</script>
@endpush
