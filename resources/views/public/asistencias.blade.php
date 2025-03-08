@extends('layouts.public')

@section('title', 'Asistencias')

@section('header-title', 'Control de Asistencias')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0 mb-6">
        <h2 class="text-xl font-semibold text-azulOscuro">Registro de Asistencias</h2>
        
        <div class="flex flex-col md:flex-row gap-4">
            <div>
                <label for="filtroEvento" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por Evento</label>
                <select id="filtroEvento" class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">
                    <option value="">Todos los eventos</option>
                    @foreach($eventos as $evento)
                    <option value="{{ $evento->id }}">{{ $evento->nombre }} ({{ $evento->fecha }})</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="filtroFecha" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por Fecha</label>
                <input type="date" id="filtroFecha" class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul focus:ring-opacity-50">
            </div>
        </div>
    </div>

    <div class="mb-6 flex justify-end">
        <a href="{{ route('public.escanear-qr') }}" class="inline-flex items-center px-4 py-2 bg-morado text-white rounded-md hover:bg-morado-dark mr-3">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
            Escanear QR
        </a>
        <button id="btnSeleccionarEvento" class="inline-flex items-center px-4 py-2 bg-azul text-white rounded-md hover:bg-azul-dark">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Registrar Asistencias
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Sediprano
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Evento
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Fecha
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
                                <div class="text-sm text-gray-500">
                                    {{ $asistencia->sediprano->codigo }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $asistencia->evento->nombre }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($asistencia->evento->fecha)->format('d/m/Y') }}
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
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                        No hay registros de asistencia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $asistencias->links() }}
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Filtrar por evento
    document.getElementById('filtroEvento').addEventListener('change', function() {
        let eventoId = this.value;
        if(eventoId) {
            window.location.href = "{{ route('public.asistencias.evento', '') }}/" + eventoId;
        } else {
            window.location.href = "{{ route('public.asistencias') }}";
        }
    });

    // Filtrar por fecha
    document.getElementById('filtroFecha').addEventListener('change', function() {
        let fecha = this.value;
        let rows = document.querySelectorAll('tbody tr');
        
        if (fecha === '') {
            rows.forEach(row => {
                row.style.display = '';
            });
            return;
        }
        
        rows.forEach(row => {
            let fechaRow = row.children[2].textContent.trim();
            let fechaFormateada = formatearFecha(fechaRow);
            
            row.style.display = fechaFormateada === fecha ? '' : 'none';
        });
    });
    
    function formatearFecha(fechaTexto) {
        // Convertir de formato dd/mm/yyyy a yyyy-mm-dd
        let partes = fechaTexto.split('/');
        if (partes.length !== 3) return '';
        return `${partes[2]}-${partes[1].padStart(2, '0')}-${partes[0].padStart(2, '0')}`;
    }

    // Botón para seleccionar evento y tomar asistencia
    document.getElementById('btnSeleccionarEvento').addEventListener('click', function() {
        const eventoId = document.getElementById('filtroEvento').value;
        if (eventoId) {
            window.location.href = "{{ url('panel-publico/tomar-asistencia') }}/" + eventoId;
        } else {
            alert('Por favor, seleccione un evento para registrar asistencias');
        }
    });
</script>
@endpush
