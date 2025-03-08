@extends('layouts.public')

@section('title', 'Eventos')

@section('header-title', 'Calendario de Eventos')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-azulOscuro">Eventos SEDIPRO</h2>
        
        <div class="flex items-center space-x-4">
            <div>
                <select id="filtroEstado" class="border rounded-lg py-2 px-3 focus:outline-none focus:ring-1 focus:ring-azul text-sm">
                    <option value="">Todos los estados</option>
                    <option value="en_curso">En curso</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="finalizado">Finalizado</option>
                </select>
            </div>
            
            <div class="relative">
                <input type="text" id="buscarEvento" placeholder="Buscar evento..." 
                       class="w-full md:w-64 pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-azul">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            
            <a href="{{ route('public.eventos.create') }}" class="px-4 py-2 bg-azul text-white rounded-md hover:bg-azul-dark flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nuevo Evento
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-700 p-4 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Evento
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Horario
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Lugar
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Estado
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($eventos as $evento)
                <tr data-estado="{{ $evento->estado }}">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $evento->nombre }}</div>
                        <div class="text-xs text-gray-500">{{ $evento->descripcion }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $evento->hora_inicio }} - {{ $evento->hora_fin }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $evento->lugar ?? 'No especificado' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($evento->estado == 'en_curso')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                En curso
                            </span>
                        @elseif($evento->estado == 'pendiente')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Pendiente
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Finalizado
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('public.asistencias.evento', $evento->id) }}" class="text-blue-600 hover:text-blue-900" title="Ver asistencias">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </a>
                            <a href="{{ route('public.tomar-asistencia', $evento->id) }}" class="text-morado hover:text-morado-dark" title="Tomar asistencia">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>
                            <a href="{{ route('public.eventos.edit', $evento->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('public.eventos.destroy', $evento->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este evento? Todas las asistencias asociadas también serán eliminadas.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                        No hay eventos registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $eventos->links() }}
    </div>
</div>

<!-- Sección de eventos destacados -->
<div class="mt-6">
    <h2 class="text-xl font-semibold text-azulOscuro mb-4">Próximos Eventos</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $proximosEventos = $eventos->where('estado', 'pendiente')->take(3);
        @endphp
        
        @forelse($proximosEventos as $evento)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-azul to-azulOscuro px-6 py-4">
                    <h3 class="text-white font-semibold truncate">{{ $evento->nombre }}</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-600 mb-3">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="flex items-center text-sm text-gray-600 mb-3">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $evento->hora_inicio }} - {{ $evento->hora_fin }}</span>
                    </div>
                    
                    @if($evento->lugar)
                        <div class="flex items-center text-sm text-gray-600 mb-4">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $evento->lugar }}</span>
                        </div>
                    @endif
                    
                    @if($evento->descripcion)
                        <p class="text-sm text-gray-700 mb-4 line-clamp-2">{{ $evento->descripcion }}</p>
                    @endif
                    
                    <div class="mt-3">
                        <a href="{{ route('public.asistencias.evento', $evento->id) }}" class="text-azul hover:text-azul-dark text-sm font-medium inline-flex items-center">
                            Ver detalles
                            <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-blue-50 text-blue-700 p-4 rounded-md">
                No hay eventos próximos programados.
            </div>
        @endforelse
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Filtro de búsqueda
    document.getElementById('buscarEvento').addEventListener('keyup', function() {
        filtrarEventos();
    });

    // Filtro por estado
    document.getElementById('filtroEstado').addEventListener('change', function() {
        filtrarEventos();
    });

    function filtrarEventos() {
        const terminoBusqueda = document.getElementById('buscarEvento').value.toLowerCase();
        const estadoSeleccionado = document.getElementById('filtroEstado').value;
        
        const filas = document.querySelectorAll('tbody tr');
        
        filas.forEach(fila => {
            const texto = fila.textContent.toLowerCase();
            const estado = fila.getAttribute('data-estado');
            
            const coincideTexto = texto.includes(terminoBusqueda);
            const coincideEstado = !estadoSeleccionado || estado === estadoSeleccionado;
            
            fila.style.display = (coincideTexto && coincideEstado) ? '' : 'none';
        });
    }
</script>
@endpush
