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
                <div id="qr-data" class="text-sm text-gray-700"></div>
                <div class="mt-2 flex space-x-3">
                    <button type="button" id="registrar-asistencia" class="px-3 py-1.5 bg-morado text-white text-sm rounded-md hover:bg-morado-dark">
                        Registrar Asistencia
                    </button>
                    <button type="button" id="cancelar-escaneo" class="px-3 py-1.5 bg-gray-200 text-gray-700 text-sm rounded-md hover:bg-gray-300">
                        Cancelar
                    </button>
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
                        Apunte la cámara al código QR del miembro para registrar su asistencia.
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
                            Si el código QR no es detectado, intente ajustar la iluminación o la distancia.
                        </p>
                        <p class="text-sm text-blue-800 mt-1">
                            También puede registrar asistencias manualmente desde la vista de "Tomar Asistencia".
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

    document.addEventListener('DOMContentLoaded', function() {
        const startButton = document.getElementById('start-camera');
        const stopButton = document.getElementById('stop-camera');
        const cameraSelect = document.getElementById('camera-select');
        const cameraPlaceholder = document.getElementById('camera-placeholder');
        const cameraPreview = document.getElementById('camera-preview');
        const scanRegion = document.getElementById('scan-region');
        const qrResultado = document.getElementById('qr-resultado');
        const qrData = document.getElementById('qr-data');
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
                        scannedData = qrCodeMessage;
                        
                        // Mostrar datos del QR
                        qrData.textContent = 'QR detectado para el miembro';
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
                        
                        // Guardar el dato QR en el campo oculto
                        document.getElementById('qr_data').value = scannedData;
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
            if (scannedData) {
                document.getElementById('qrForm').submit();
            }
        });
        
        // Cancelar escaneo
        cancelarBtn.addEventListener('click', function() {
            qrResultado.classList.add('hidden');
            qrScanned = false;
            scannedData = null;
        });
    });
</script>
@endpush
