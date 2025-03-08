@extends('layouts.public')

@section('title', 'Escanear QR')

@section('header-title', 'Registro de Asistencia por QR')

@section('content')
<div class="mb-4">
    <a href="{{ route('public.eventos') }}" class="inline-flex items-center text-sm text-azul hover:text-azul-dark">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Volver a eventos
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-azulOscuro mb-6">Escanear QR para Asistencia</h2>
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-md flex items-center">
                    <svg class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('warning'))
                <div class="mb-6 bg-yellow-50 border border-yellow-200 text-yellow-700 p-4 rounded-md flex items-center">
                    <svg class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    {{ session('warning') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-md flex items-center">
                    <svg class="h-5 w-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            
            <form id="qrForm" action="{{ route('public.procesar-qr') }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label for="evento_id" class="block text-sm font-medium text-gray-700 mb-1">Evento*</label>
                    <select id="evento_id" name="evento_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                        <option value="">-- Seleccione un evento --</option>
                        @foreach($eventos as $evento)
                            <option value="{{ $evento->id }}">
                                {{ $evento->nombre }} ({{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <input type="hidden" id="qr_data" name="qr_data">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cámara</label>
                    <div class="relative">
                        <select id="camera-select" class="mb-4 border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20 w-full">
                            <option value="">Cargando cámaras...</option>
                        </select>
                        <div id="camera-container" class="w-full bg-black aspect-video flex items-center justify-center rounded-lg overflow-hidden relative">
                            <div id="camera-placeholder" class="text-white text-center p-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="mt-2">Haga clic en "Iniciar Cámara" para comenzar</p>
                            </div>
                            <video id="camera-preview" class="w-full h-full object-cover hidden"></video>
                        </div>
                        
                        <div id="scan-region" class="absolute top-0 left-0 right-0 bottom-0 pointer-events-none hidden">
                            <div class="absolute inset-0 border-2 border-azul/70 rounded-lg"></div>
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-2/3 h-2/3 border-2 border-azul/70 rounded-lg">
                                <div class="absolute top-0 left-0 w-4 h-4 border-t-2 border-l-2 border-azul rounded-tl-lg"></div>
                                <div class="absolute top-0 right-0 w-4 h-4 border-t-2 border-r-2 border-azul rounded-tr-lg"></div>
                                <div class="absolute bottom-0 left-0 w-4 h-4 border-b-2 border-l-2 border-azul rounded-bl-lg"></div>
                                <div class="absolute bottom-0 right-0 w-4 h-4 border-b-2 border-r-2 border-azul rounded-br-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex space-x-4">
                    <button type="button" id="start-camera" class="px-4 py-2 bg-azul text-white rounded-md hover:bg-azul-dark">
                        Iniciar Cámara
                    </button>
                    <button type="button" id="stop-camera" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 hidden">
                        Detener Cámara
                    </button>
                </div>
            </form>
            
            <div id="qr-resultado" class="mt-4 bg-gray-50 p-4 rounded-md hidden">
                <h3 class="font-medium text-gray-900 mb-2">Resultado del escaneo:</h3>
                <div id="qr-data-display" class="text-sm text-gray-700 mb-2"></div>
                <div id="qr-code-info" class="text-xs text-gray-500 mb-3"></div>
                <div class="mt-2 flex space-x-3">
                    <button type="button" id="registrar-asistencia" class="px-3 py-1.5 bg-morado text-white text-sm rounded-md hover:bg-morado-dark">
                        Registrar Asistencia
                    </button>
                    <button type="button" id="cancelar-escaneo" class="px-3 py-1.5 bg-gray-200 text-gray-700 text-sm rounded-md hover:bg-gray-300">
                        Cancelar
                    </button>
                </div>
            </div>
            
            <!-- Lista de asistencias registradas en esta sesión -->
            <div class="mt-8 border-t border-gray-200 pt-6" id="asistencias-recientes">
                <h3 class="font-medium text-lg mb-4">Asistencias Registradas (Sesión actual)</h3>
                <div id="asistencias-lista" class="space-y-3">
                    <!-- Las asistencias se añadirán aquí dinámicamente -->
                    <p id="no-asistencias" class="text-gray-500 text-sm">No hay asistencias registradas en esta sesión</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Panel lateral con instrucciones -->
    <div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-azulOscuro mb-4">Instrucciones</h2>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-5 w-5 relative mt-1">
                        <div class="absolute inset-0 bg-morado rounded-full opacity-20"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-morado text-xs font-medium">1</span>
                        </div>
                    </div>
                    <p class="ml-2 text-sm text-gray-700">
                        Seleccione el evento para el que desea registrar asistencia.
                    </p>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-5 w-5 relative mt-1">
                        <div class="absolute inset-0 bg-morado rounded-full opacity-20"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-morado text-xs font-medium">2</span>
                        </div>
                    </div>
                    <p class="ml-2 text-sm text-gray-700">
                        Haga clic en "Iniciar Cámara" y seleccione la cámara que desea utilizar.
                    </p>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-5 w-5 relative mt-1">
                        <div class="absolute inset-0 bg-morado rounded-full opacity-20"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-morado text-xs font-medium">3</span>
                        </div>
                    </div>
                    <p class="ml-2 text-sm text-gray-700">
                        Apunte la cámara al código QR del miembro conforme vayan llegando.
                    </p>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-5 w-5 relative mt-1">
                        <div class="absolute inset-0 bg-morado rounded-full opacity-20"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-morado text-xs font-medium">4</span>
                        </div>
                    </div>
                    <p class="ml-2 text-sm text-gray-700">
                        Una vez detectado el QR, confirme el registro haciendo clic en "Registrar Asistencia".
                    </p>
                </div>
            </div>
            
            <div class="mt-6 p-3 bg-blue-50 rounded-md">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-sm text-blue-800">
                            Este sistema permite tomar asistencia uno por uno conforme van llegando los participantes.
                        </p>
                        <p class="text-sm text-blue-800 mt-1">
                            La cámara seguirá activa para escanear más códigos después de cada registro.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.0/html5-qrcode.min.js"></script>
<script>
    let html5QrCode;
    let qrScanned = false;
    let scannedData = null;
    let processingQr = false;
    let registredAttendances = [];
    
    // Elementos de audio
    const successSound = document.getElementById('success-sound');
    const errorSound = document.getElementById('error-sound');

    document.addEventListener('DOMContentLoaded', function() {
        const startButton = document.getElementById('start-camera');
        const stopButton = document.getElementById('stop-camera');
        const cameraSelect = document.getElementById('camera-select');
        const cameraPlaceholder = document.getElementById('camera-placeholder');
        const cameraPreview = document.getElementById('camera-preview');
        const scanRegion = document.getElementById('scan-region');
        const qrResultado = document.getElementById('qr-resultado');
        const qrDataDisplay = document.getElementById('qr-data-display');
        const qrCodeInfo = document.getElementById('qr-code-info');
        const registrarBtn = document.getElementById('registrar-asistencia');
        const cancelarBtn = document.getElementById('cancelar-escaneo');
        
        // Cargar cámaras disponibles
        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length) {
                cameraSelect.innerHTML = '';
                cameras.forEach(camera => {
                    const option = document.createElement('option');
                    option.value = camera.id;
                    option.text = camera.label || `Cámara ${camera.id}`;
                    cameraSelect.add(option);
                });
            } else {
                cameraSelect.innerHTML = '<option value="">No se encontraron cámaras</option>';
            }
        }).catch(err => {
            console.error('Error al obtener cámaras:', err);
            cameraSelect.innerHTML = '<option value="">Error al cargar cámaras</option>';
        });
        
        // Iniciar cámara
        startButton.addEventListener('click', function() {
            const cameraId = cameraSelect.value;
            
            if (!cameraId) {
                alert('Por favor seleccione una cámara');
                return;
            }
            
            const eventoId = document.getElementById('evento_id').value;
            if (!eventoId) {
                alert('Por favor seleccione un evento');
                return;
            }
            
            cameraPlaceholder.classList.add('hidden');
            cameraPreview.classList.remove('hidden');
            scanRegion.classList.remove('hidden');
            
            html5QrCode = new Html5Qrcode('camera-container');
            html5QrCode.start(
                cameraId,
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                },
                qrCodeMessage => {
                    if (!qrScanned) {
                        qrScanned = true;
                        
                        try {
                            // Intentar parsear los datos JSON del QR
                            scannedData = JSON.parse(qrCodeMessage);
                            
                            // Mostrar información básica del código escaneado
                            qrDataDisplay.textContent = `Código QR válido detectado`;
                            qrCodeInfo.textContent = `ID: ${scannedData.id} | Código: ${scannedData.codigo}`;
                            
                            // Guardar el dato QR en el campo oculto (como JSON string)
                            document.getElementById('qr_data').value = JSON.stringify(scannedData);
                            
                        } catch (e) {
                            // Si no se puede parsear como JSON, puede ser otro formato
                            scannedData = qrCodeMessage;
                            qrDataDisplay.textContent = 'Formato de QR no reconocido';
                            qrCodeInfo.textContent = 'El código no parece ser un QR válido de SEDIPRO';
                            document.getElementById('qr_data').value = qrCodeMessage;
                        }
                        
                        qrResultado.classList.remove('hidden');
                        
                        // Parpadear el borde para indicar detección
                        scanRegion.classList.add('border-green-500');
                        setTimeout(() => {
                            scanRegion.classList.remove('border-green-500');
                        }, 500);
                        
                        // Vibrar si está disponible
                        if (navigator.vibrate) {
                            navigator.vibrate(200);
                        }
                    }
                },
                errorMessage => {
                    // Ignoramos errores mientras escanea
                }
            ).catch(err => {
                console.error('Error al iniciar la cámara:', err);
                alert('Error al iniciar la cámara: ' + err);
            });
            
            startButton.classList.add('hidden');
            stopButton.classList.remove('hidden');
        });
        
        // Detener cámara
        stopButton.addEventListener('click', function() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    cameraPlaceholder.classList.remove('hidden');
                    cameraPreview.classList.add('hidden');
                    scanRegion.classList.add('hidden');
                    startButton.classList.remove('hidden');
                    stopButton.classList.add('hidden');
                    qrScanned = false;
                    qrResultado.classList.add('hidden');
                });
            }
        });
        
        // Registrar asistencia
        registrarBtn.addEventListener('click', function() {
            if (!scannedData) return;
            
            const eventoId = document.getElementById('evento_id').value;
            if (!eventoId) {
                alert('Por favor seleccione un evento');
                return;
            }
            
            // Deshabilitamos el botón mientras se procesa
            registrarBtn.disabled = true;
            registrarBtn.innerHTML = 'Procesando...';
            
            fetch('{{ route('public.procesar-qr') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    qr_data: scannedData,
                    evento_id: eventoId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Agregar a la lista de asistencias registradas
                    addRegisteredAttendance({
                        nombre: data.nombre || 'Miembro',
                        codigo: scannedData.codigo || 'N/A',
                        hora: new Date().toLocaleTimeString()
                    });
                    
                    // Mostrar notificación
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3';
                    notification.innerHTML = `
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>${data.message || '¡Asistencia registrada con éxito!'}</span>
                    `;
                    document.body.appendChild(notification);
                    
                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                } else {
                    alert(data.message || 'Error al registrar la asistencia');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            })
            .finally(() => {
                // Resetear para siguiente escaneo
                qrScanned = false;
                scannedData = null;
                qrResultado.classList.add('hidden');
                registrarBtn.disabled = false;
                registrarBtn.innerHTML = 'Registrar Asistencia';
            });
        });
        
        // Cancelar escaneo
        cancelarBtn.addEventListener('click', function() {
            qrResultado.classList.add('hidden');
            qrScanned = false;
            scannedData = null;
        });
        
        // Función para añadir una asistencia a la lista visual
        function addRegisteredAttendance(attendance) {
            registredAttendances.push(attendance);
            
            // Ocultar el mensaje de "no hay asistencias"
            document.getElementById('no-asistencias').style.display = 'none';
            
            // Crear el elemento de la asistencia
            const asistenciasLista = document.getElementById('asistencias-lista');
            const asistenciaEl = document.createElement('div');
            asistenciaEl.className = 'flex items-center justify-between bg-green-50 p-3 rounded-md border border-green-100';
            
            asistenciaEl.innerHTML = `
                <div class="flex items-center">
                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold mr-3">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">${attendance.nombre}</p>
                        <p class="text-xs text-gray-500">Código: ${attendance.codigo}</p>
                    </div>
                </div>
                <div class="text-xs text-gray-500">${attendance.hora}</div>
            `;
            
            // Añadir al principio de la lista
            asistenciasLista.insertBefore(asistenciaEl, asistenciasLista.firstChild);
        }

        // Registrar asistencia automáticamente
        function registrarAsistenciaAutomatica(qrData) {
            const eventoId = document.getElementById('evento_id').value;
            
            fetch('{{ route('public.procesar-qr') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    qr_data: qrData,
                    evento_id: eventoId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Actualizar icono y mensaje de éxito
                    qrStatusIcon.innerHTML = `
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    `;
                    qrStatusIcon.className = 'h-8 w-8 mr-3 flex items-center justify-center rounded-full bg-green-100 text-green-600';
                    qrMessage.textContent = '¡Asistencia registrada con éxito!';
                    
                    // Reproducir sonido de éxito
                    successSound.play();
                    
                    // Agregar a la lista de asistencias registradas
                    addRegisteredAttendance({
                        nombre: data.nombre || 'Miembro',
                        codigo: qrData.codigo || 'N/A',
                        hora: new Date().toLocaleTimeString(),
                        estado: 'success'
                    });
                    
                    // Mostrar notificación
                    mostrarNotificacion('¡Asistencia registrada con éxito!', 'success');
                } else if (data.status === 'warning') {
                    // Actualizar icono y mensaje de advertencia
                    qrStatusIcon.innerHTML = `
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    `;
                    qrStatusIcon.className = 'h-8 w-8 mr-3 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600';
                    qrMessage.textContent = data.message || 'Ya registrado previamente';
                    
                    // Reproducir sonido de error
                    errorSound.play();
                    
                    // Mostrar notificación
                    mostrarNotificacion(data.message, 'warning');
                } else {
                    // Actualizar icono y mensaje de error
                    qrStatusIcon.innerHTML = `
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    `;
                    qrStatusIcon.className = 'h-8 w-8 mr-3 flex items-center justify-center rounded-full bg-red-100 text-red-600';
                    qrMessage.textContent = data.message || 'Error al registrar asistencia';
                    
                    // Reproducir sonido de error
                    errorSound.play();
                    
                    // Mostrar notificación
                    mostrarNotificacion(data.message || 'Error al registrar asistencia', 'error');
                }
                
                // Limpiar después de unos segundos para escanear el siguiente
                setTimeout(() => {
                    qrResultado.classList.add('hidden');
                    qrScanned = false;
                    processingQr = false;
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
                qrStatusIcon.innerHTML = `
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                `;
                qrStatusIcon.className = 'h-8 w-8 mr-3 flex items-center justify-center rounded-full bg-red-100 text-red-600';
                qrMessage.textContent = 'Error de conexión';
                
                // Reproducir sonido de error
                errorSound.play();
                
                // Limpiar después de unos segundos
                setTimeout(() => {
                    qrResultado.classList.add('hidden');
                    qrScanned = false;
                    processingQr = false;
                }, 3000);
            });
        }
        
        // Registro manual individual
        registrarManualBtn.addEventListener('click', function() {
            const eventoId = document.getElementById('evento_id').value;
            if (!eventoId) {
                alert('Por favor seleccione un evento');
                return;
            }
            
            const codigoODni = document.getElementById('manual_sediprano').value;
            if (!codigoODni) {
                alert('Ingrese un código o DNI válido');
                return;
            }
            
            const estado = document.getElementById('manual_estado').value;
            const observacion = document.getElementById('manual_observacion').value;
            
            // Deshabilitar el botón mientras se procesa
            registrarManualBtn.disabled = true;
            registrarManualBtn.innerText = 'Procesando...';
            
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
                    // Actualizar la lista de asistencias registradas
                    addRegisteredAttendance({
                        nombre: data.nombre || 'Miembro',
                        codigo: codigoODni,
                        hora: new Date().toLocaleTimeString(),
                        estado: 'success'
                    });
                    
                    // Notificación
                    mostrarNotificacion('Asistencia registrada con éxito', 'success');
                    
                    // Limpiar formulario
                    document.getElementById('manual_sediprano').value = '';
                    document.getElementById('manual_observacion').value = '';
                    
                    // Reproducir sonido de éxito
                    successSound.play();
                } else {
                    // Notificación
                    mostrarNotificacion(data.message || 'Error al registrar asistencia', 'error');
                    
                    // Reproducir sonido de error
                    errorSound.play();
                }
            })
            .catch(error => {
                // Notificación
                mostrarNotificacion('Error de conexión: ' + error.message, 'error');
                
                // Reproducir sonido de error
                errorSound.play();
            })
            .finally(() => {
                registrarManualBtn.disabled = false;
                registrarManualBtn.innerText = 'Registrar Asistencia Manual';
            });
        });
        
        // Función para agregar asistencia registrada a la lista
        function addRegisteredAttendance(attendance) {
            // Eliminar el mensaje "no hay asistencias"
            const noAsistencias = document.getElementById('no-asistencias');
            if (noAsistencias) {
                noAsistencias.style.display = 'none';
            }
            
            // Crear nuevo elemento de asistencia
            const asistenciasLista = document.getElementById('asistencias-lista');
            const asistenciaEl = document.createElement('div');
            
            asistenciaEl.className = 'bg-green-50 border border-green-100 rounded-md p-3 flex justify-between items-center';
            asistenciaEl.innerHTML = `
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full h-10 w-10 flex items-center justify-center mr-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">${attendance.nombre}</p>
                        <p class="text-sm text-gray-500">Código: ${attendance.codigo}</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    ${attendance.hora}
                </div>
            `;
            
            // Añadir al inicio de la lista
            if (asistenciasLista.firstChild) {
                asistenciasLista.insertBefore(asistenciaEl, asistenciasLista.firstChild);
            } else {
                asistenciasLista.appendChild(asistenciaEl);
            }
            
            // Guardar en la lista
            registredAttendances.push(attendance);
        }
        
        // Función para mostrar notificaciones
        function mostrarNotificacion(mensaje, tipo) {
            const notificacion = document.createElement('div');
            let bgcolor = 'bg-blue-500';
            
            if (tipo === 'success') bgcolor = 'bg-green-500';
            else if (tipo === 'error') bgcolor = 'bg-red-500';
            else if (tipo === 'warning') bgcolor = 'bg-yellow-500';
            
            notificacion.className = `${bgcolor} text-white py-2 px-4 rounded-md shadow-lg`;
            notificacion.style.position = 'fixed';
            notificacion.style.bottom = '20px';
            notificacion.style.right = '20px';
            notificacion.style.zIndex = '50';
            notificacion.textContent = mensaje;
            
            document.body.appendChild(notificacion);
            
            setTimeout(() => {
                notificacion.remove();
            }, 3000);
        }
    });
</script>
@endpush
