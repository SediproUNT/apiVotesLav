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
                    <option value="{{ $evento->id }}" data-fecha="{{ $evento->fecha }}">
                        {{ $evento->nombre }} ({{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }})
                    </option>
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
        <button id="btnTomarAsistencia" class="inline-flex items-center px-4 py-2 bg-azul text-white rounded-md hover:bg-azul-dark">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tomar Asistencia Individual
        </button>
    </div>

    <div id="loading-indicator" class="text-center py-8 hidden">
        <svg class="animate-spin h-8 w-8 text-azul mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="mt-3 text-sm text-gray-500">Cargando asistencias...</p>
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
            <tbody id="asistencias-tbody" class="bg-white divide-y divide-gray-200">
                @forelse ($asistencias as $asistencia)
                <tr data-evento="{{ $asistencia->evento_id }}" data-fecha="{{ \Carbon\Carbon::parse($asistencia->evento->fecha)->format('Y-m-d') }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-azulOscuro/10 flex items-center justify-center text-azulOscuro font-bold">
                                    {{ substr($asistencia->sediprano->user->name ?? 'U', 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $asistencia->sediprano->user->name ?? 'Usuario no disponible' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $asistencia->sediprano->codigo ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $asistencia->evento->nombre ?? 'Evento no disponible' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($asistencia->evento->fecha ?? now())->format('d/m/Y') }}
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
    <div class="mt-4" id="pagination-container">
        {{ $asistencias->links() }}
    </div>
</div>

<!-- Modal para registrar asistencia individual -->
<div id="modalAsistencia" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 overflow-hidden">
        <div class="bg-gradient-to-r from-azul to-azulOscuro px-6 py-4 flex justify-between items-center">
            <h3 class="text-white text-lg font-semibold">Registrar Asistencia Individual</h3>
            <button id="cerrarModal" class="text-white hover:text-gray-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <label for="modal-evento" class="block text-sm font-medium text-gray-700 mb-1">Evento*</label>
                <select id="modal-evento" class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                    @foreach($eventos as $evento)
                    <option value="{{ $evento->id }}">
                        {{ $evento->nombre }} ({{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }})
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="modal-sediprano" class="block text-sm font-medium text-gray-700 mb-1">Código o DNI del miembro*</label>
                <input type="text" id="modal-sediprano" class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" 
                       placeholder="Ingrese código o DNI" required>
            </div>
            
            <div class="mb-4">
                <label for="modal-estado" class="block text-sm font-medium text-gray-700 mb-1">Estado*</label>
                <select id="modal-estado" class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                    <option value="presente">Presente</option>
                    <option value="tardanza">Tardanza</option>
                    <option value="falta">Falta</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label for="modal-observacion" class="block text-sm font-medium text-gray-700 mb-1">Observación</label>
                <input type="text" id="modal-observacion" class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" 
                       placeholder="Opcional">
            </div>
            
            <div id="modal-error" class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-md mb-4 hidden"></div>
            <div id="modal-success" class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-md mb-4 hidden"></div>
            
            <div class="flex justify-end">
                <button id="btn-cancelar" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md mr-2 hover:bg-gray-300">
                    Cancelar
                </button>
                <button id="btn-guardar-asistencia" class="px-4 py-2 bg-azul text-white rounded-md hover:bg-azul-dark">
                    Guardar Asistencia
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Audio elements para sonidos -->
<audio id="success-sound" src="{{ asset('sounds/success.mp3') }}" preload="auto"></audio>
<audio id="error-sound" src="{{ asset('sounds/error.mp3') }}" preload="auto"></audio>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Referencias a elementos DOM
        const filtroEvento = document.getElementById('filtroEvento');
        const filtroFecha = document.getElementById('filtroFecha');
        const asistenciasTbody = document.getElementById('asistencias-tbody');
        const btnTomarAsistencia = document.getElementById('btnTomarAsistencia');
        const loadingIndicator = document.getElementById('loading-indicator');
        const modal = document.getElementById('modalAsistencia');
        const modalEvento = document.getElementById('modal-evento');
        const modalSediprano = document.getElementById('modal-sediprano');
        const modalEstado = document.getElementById('modal-estado');
        const modalObservacion = document.getElementById('modal-observacion');
        const modalError = document.getElementById('modal-error');
        const modalSuccess = document.getElementById('modal-success');
        const btnCancelar = document.getElementById('btn-cancelar');
        const btnGuardarAsistencia = document.getElementById('btn-guardar-asistencia');
        const cerrarModal = document.getElementById('cerrarModal');
        const successSound = document.getElementById('success-sound');
        const errorSound = document.getElementById('error-sound');
        
        // Filtrar por evento sin redirección
        filtroEvento.addEventListener('change', function() {
            filtrarAsistencias();
        });

        // Filtrar por fecha
        filtroFecha.addEventListener('change', function() {
            filtrarAsistencias();
        });
        
        // Mostrar modal para tomar asistencia individual
        btnTomarAsistencia.addEventListener('click', function() {
            // Si hay un evento seleccionado, usarlo en el modal
            if (filtroEvento.value) {
                modalEvento.value = filtroEvento.value;
            }
            
            abrirModal();
        });
        
        // Cerrar modal
        btnCancelar.addEventListener('click', cerrarModalFunc);
        cerrarModal.addEventListener('click', cerrarModalFunc);
        
        // Guardar asistencia individual
        btnGuardarAsistencia.addEventListener('click', function() {
            const eventoId = modalEvento.value;
            const codigoODni = modalSediprano.value;
            const estado = modalEstado.value;
            const observacion = modalObservacion.value;
            
            if (!eventoId || !codigoODni || !estado) {
                mostrarError('Por favor complete todos los campos obligatorios');
                return;
            }
            
            btnGuardarAsistencia.disabled = true;
            btnGuardarAsistencia.textContent = 'Procesando...';
            
            fetch('{{ route('public.registrar-manual') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    evento_id: eventoId,
                    codigo_dni: codigoODni,
                    estado: estado,
                    observacion: observacion
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    mostrarExito(data.message || 'Asistencia registrada con éxito');
                    modalSediprano.value = '';
                    successSound.play();
                    
                    // Recargar las asistencias después de registrar
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    mostrarError(data.message || 'Error al registrar asistencia');
                    errorSound.play();
                }
            })
            .catch(error => {
                mostrarError('Error de conexión: ' + error.message);
                errorSound.play();
            })
            .finally(() => {
                btnGuardarAsistencia.disabled = false;
                btnGuardarAsistencia.textContent = 'Guardar Asistencia';
            });
        });
        
        function filtrarAsistencias() {
            const eventoId = filtroEvento.value;
            const fechaSeleccionada = filtroFecha.value;
            let filas = asistenciasTbody.querySelectorAll('tr');
            let algunoVisible = false;
            
            filas.forEach(fila => {
                // No aplicamos filtro a la fila de "No hay registros"
                if (fila.querySelectorAll('td').length === 1 && fila.querySelector('td').getAttribute('colspan')) {
                    return;
                }
                
                const filaEventoId = fila.getAttribute('data-evento');
                const filaFecha = fila.getAttribute('data-fecha');
                
                let coincideEvento = true;
                let coincideFecha = true;
                
                if (eventoId) {
                    coincideEvento = filaEventoId === eventoId;
                }
                
                if (fechaSeleccionada) {
                    coincideFecha = filaFecha === fechaSeleccionada;
                }
                
                const visible = coincideEvento && coincideFecha;
                fila.style.display = visible ? '' : 'none';
                
                if (visible) algunoVisible = true;
            });
            
            // Mostrar mensaje si no hay resultados
            let noResultados = asistenciasTbody.querySelector('.no-resultados');
            
            if (!algunoVisible) {
                if (!noResultados) {
                    noResultados = document.createElement('tr');
                    noResultados.className = 'no-resultados';
                    noResultados.innerHTML = `
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No se encontraron resultados para el filtro aplicado
                        </td>
                    `;
                    asistenciasTbody.appendChild(noResultados);
                } else {
                    noResultados.style.display = '';
                }
            } else if (noResultados) {
                noResultados.style.display = 'none';
            }
        }
        
        function abrirModal() {
            modal.classList.remove('hidden');
            modalSediprano.focus();
            limpiarMensajes();
        }
        
        function cerrarModalFunc() {
            modal.classList.add('hidden');
            limpiarMensajes();
            modalSediprano.value = '';
            modalObservacion.value = '';
        }
        
        function mostrarError(mensaje) {
            modalError.textContent = mensaje;
            modalError.classList.remove('hidden');
            modalSuccess.classList.add('hidden');
        }
        
        function mostrarExito(mensaje) {
            modalSuccess.textContent = mensaje;
            modalSuccess.classList.remove('hidden');
            modalError.classList.add('hidden');
        }
        
        function limpiarMensajes() {
            modalError.classList.add('hidden');
            modalSuccess.classList.add('hidden');
        }
    });
</script>
@endpush
