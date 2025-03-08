@extends('layouts.public')

@section('title', 'Sedipranos')

@section('header-title', 'Miembros SEDIPRO')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-azulOscuro">Listado de Miembros</h2>
        <a href="{{ route('public.sedipranos.create') }}" class="px-4 py-2 bg-azul text-white rounded-md hover:bg-azul-dark flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nuevo Miembro
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-700 p-4 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 flex items-center space-x-4">
        <div class="relative flex-grow">
            <input type="text" id="buscarSediprano" placeholder="Buscar por nombre o código..." 
                   class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-azul">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        
        <div>
            <select id="filtroArea" class="border rounded-lg py-2 px-3 focus:outline-none focus:ring-1 focus:ring-azul">
                <option value="">Todas las áreas</option>
                @foreach($areas as $area)
                <option value="{{ $area->nombre }}">{{ $area->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Código
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Miembro
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Área
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Carrera
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Cargo
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($sedipranos as $sediprano)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
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
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $sediprano->user->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $sediprano->dni }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $sediprano->area->nombre ?? 'Sin área' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $sediprano->carrera->nombre ?? 'Sin carrera' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $sediprano->cargo->nombre ?? 'Sin cargo' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('public.sedipranos.perfil', $sediprano->id) }}" class="text-blue-600 hover:text-blue-900" title="Ver perfil">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('public.sedipranos.edit', $sediprano->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('public.sedipranos.destroy', $sediprano->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este miembro?')">
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
                        No hay miembros registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $sedipranos->links() }}
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Búsqueda en la tabla
    document.getElementById('buscarSediprano').addEventListener('keyup', function() {
        let input = this.value.toLowerCase();
        filtrarTabla();
    });

    // Filtro por área
    document.getElementById('filtroArea').addEventListener('change', function() {
        filtrarTabla();
    });

    function filtrarTabla() {
        let input = document.getElementById('buscarSediprano').value.toLowerCase();
        let areaSeleccionada = document.getElementById('filtroArea').value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            let area = row.children[2].textContent.toLowerCase();
            
            let coincideTexto = text.includes(input);
            let coincideArea = !areaSeleccionada || area.includes(areaSeleccionada);
            
            row.style.display = (coincideTexto && coincideArea) ? '' : 'none';
        });
    }
</script>
@endpush
