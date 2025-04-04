<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Emisión de Voto - SEDIPRO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.3/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        azulOscuro: '#292d66',
                        azul: '#3154a2',
                        morado: '#672577',
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gray-50">
    <div x-data="votacionApp()" x-init="iniciarContador()" class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <img src="https://storage.googleapis.com/imagenes_bananos/votes/logos/logo-sedipro.png" 
                     alt="SEDIPRO UNT" class="w-20">
                <div class="text-lg font-semibold bg-morado/10 text-morado px-4 py-2 rounded-lg" x-text="tiempoRestante">
                    <!-- Countdown timer -->
                </div>
            </div>

            <div class="flex items-center gap-3 mb-4">
                <svg class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-gray-700">Bienvenido(a), {{ $data['sediprano']['user']['name'] }}</span>
            </div>

            <h1 class="text-2xl md:text-3xl font-bold text-azulOscuro mb-2">
                {{ $data['votacion']['name'] }}
            </h1>
            <p class="text-gray-500">
                {{ \Carbon\Carbon::parse($data['votacion']['fecha'])->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
            </p>
        </header>

        <!-- Secciones de Votación -->
        <div class="space-y-8">
            <!-- Presidente -->
            <section>
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-6 h-6 text-azul" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-xl font-semibold text-azul">Candidatos a Presidente</h2>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($data['candidatos']['presidencia'] as $index => $candidato)
                    <div class="relative">
                        <input type="radio" name="presidente" id="presidente_{{ $candidato['id'] }}" 
                               value="{{ $candidato['id'] }}" class="peer hidden" required>
                        <label for="presidente_{{ $candidato['id'] }}" 
                               class="block p-6 bg-white rounded-lg shadow-sm border border-gray-200
                                      peer-checked:bg-azul/5 peer-checked:border-azul 
                                      transition-all cursor-pointer h-72">
                            <div class="absolute top-4 left-4 w-8 h-8 flex items-center justify-center
                                      bg-azul/10 text-azul rounded-full font-semibold">
                                {{ chr(65 + $index) }}
                            </div>
                            <div class="flex flex-col items-center justify-center h-full">
                                @if($candidato['foto'])
                                    <img src="{{ $candidato['foto'] }}" alt="Foto candidato" 
                                         class="w-32 h-32 rounded-full object-cover mb-4 border-2 border-azul/20">
                                @else
                                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mb-4 border-2 border-azul/20">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                                <h3 class="text-lg font-semibold text-center">
                                    {{ $candidato['nombres'] }} {{ $candidato['primer_apellido'] }}
                                </h3>
                                <p class="text-gray-500 text-sm text-center mt-1">{{ $candidato['postula_a'] }}</p>
                            </div>
                            <div class="absolute top-4 right-4 hidden peer-checked:block">
                                <svg class="w-6 h-6 text-azul" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </label>
                    </div>
                    @endforeach

                    <!-- Voto en Blanco -->
                    <div class="relative">
                        <input type="radio" name="presidente" id="presidente_blanco" value="blanco" class="peer hidden">
                        <label for="presidente_blanco" 
                               class="block p-6 bg-white rounded-lg shadow-sm border border-gray-200
                                      peer-checked:bg-azul/5 peer-checked:border-azul 
                                      transition-all cursor-pointer h-72">
                            <div class="flex flex-col items-center justify-center h-full">
                                <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center mb-4 border-2 border-gray-200">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                              d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold">Voto en Blanco</h3>
                                <p class="text-gray-500 text-sm text-center mt-1">No seleccionar ningún candidato</p>
                            </div>
                            <div class="absolute top-4 right-4 hidden peer-checked:block">
                                <svg class="w-6 h-6 text-azul" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Director de Área -->
            <section>
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-6 h-6 text-morado" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h2 class="text-xl font-semibold text-morado">
                        Candidatos a Director - {{ $data['sediprano']['area']['nombre'] }}
                    </h2>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($data['candidatos']['area'] as $index => $candidato)
                    <div class="relative">
                        <input type="radio" name="director" id="director_{{ $candidato['id'] }}" 
                               value="{{ $candidato['id'] }}" class="peer hidden" required>
                        <label for="director_{{ $candidato['id'] }}" 
                               class="block p-6 bg-white rounded-lg shadow-sm border border-gray-200
                                      peer-checked:bg-morado/5 peer-checked:border-morado 
                                      transition-all cursor-pointer h-72">
                            <div class="absolute top-4 left-4 w-8 h-8 flex items-center justify-center
                                      bg-morado/10 text-morado rounded-full font-semibold">
                                {{ chr(65 + $index) }}
                            </div>
                            <div class="flex flex-col items-center justify-center h-full">
                                @if($candidato['foto'])
                                    <img src="{{ $candidato['foto'] }}" alt="Foto candidato" 
                                         class="w-32 h-32 rounded-full object-cover mb-4 border-2 border-morado/20">
                                @else
                                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mb-4 border-2 border-morado/20">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                                <h3 class="text-lg font-semibold text-center">
                                    {{ $candidato['nombres'] }} {{ $candidato['primer_apellido'] }}
                                </h3>
                                <p class="text-gray-500 text-sm text-center mt-1">{{ $candidato['postula_a'] }}</p>
                            </div>
                            <div class="absolute top-4 right-4 hidden peer-checked:block">
                                <svg class="w-6 h-6 text-morado" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </label>
                    </div>
                    @endforeach

                    <!-- Voto en Blanco -->
                    <div class="relative">
                        <input type="radio" name="director" id="director_blanco" value="blanco" class="peer hidden">
                        <label for="director_blanco" 
                               class="block p-6 bg-white rounded-lg shadow-sm border border-gray-200
                                      peer-checked:bg-morado/5 peer-checked:border-morado 
                                      transition-all cursor-pointer h-72">
                            <div class="flex flex-col items-center justify-center h-full">
                                <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center mb-4 border-2 border-gray-200">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                              d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold">Voto en Blanco</h3>
                                <p class="text-gray-500 text-sm text-center mt-1">No seleccionar ningún candidato</p>
                            </div>
                            <div class="absolute top-4 right-4 hidden peer-checked:block">
                                <svg class="w-6 h-6 text-morado" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </label>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="mt-8 flex items-center justify-between">
            <button onclick="history.back()" 
                    class="px-6 py-3 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                ← Regresar
            </button>
            <button id="btnEmitirVoto" 
                    @click="verificarSeleccion()"
                    class="px-6 py-3 bg-azulOscuro text-white rounded-lg hover:bg-[#1d214d] 
                           focus:outline-none focus:ring-4 focus:ring-azulOscuro/30">
                Emitir Voto
            </button>
        </footer>

        <div class="mt-4 text-center text-sm text-gray-500">
            <p>Votaciones Sedipranas 2025</p>
            <p class="mt-1">Si tienes problemas para votar, contacta al área de TI</p>
        </div>
    
        <!-- Modal informativo de votación -->
        <div x-show="modalAbierto" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
            <div x-show="modalAbierto"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="bg-white rounded-xl max-w-lg w-full mx-4 overflow-hidden shadow-2xl transform">
                
                <!-- Encabezado del modal -->
                <div class="p-6 bg-gradient-to-r from-azul to-azulOscuro">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-medium text-white">Resumen de Votación</h3>
                    </div>
                </div>
                
                <!-- Contenido del modal -->
                <div class="p-6">
                    <div class="mb-5 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100">
                            <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="mt-2 text-lg font-semibold text-gray-800">Has seleccionado:</h4>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-azul mb-2">Para Presidente:</h4>
                            <div id="presidenteSeleccionado" class="flex items-center gap-3">
                                <!-- Se llenará dinámicamente -->
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-morado mb-2">Para Director:</h4>
                            <div id="directorSeleccionado" class="flex items-center gap-3">
                                <!-- Se llenará dinámicamente -->
                            </div>
                        </div>
                        
                        <!-- Contador de proceso -->
                        <div x-show="procesando" class="flex flex-col items-center justify-center py-4">
                            <svg class="animate-spin h-8 w-8 text-azul mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-azul font-medium">Procesando tu voto...</p>
                        </div>
                        
                        <!-- Mensaje de éxito -->
                        <div x-show="votoExitoso" class="bg-green-50 text-green-800 p-4 rounded-md flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div>
                                <p class="font-medium">¡Voto emitido correctamente!</p>
                                <p class="text-sm">Serás redirigido en unos segundos...</p>
                            </div>
                        </div>
                        
                        <!-- Información -->
                        <div x-show="!votoExitoso && !procesando" class="bg-blue-50 text-blue-800 p-4 rounded-md">
                            <p class="text-sm">Una vez emitido el voto no podrás cambiarlo. Esta acción no se puede deshacer.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Botones de acción -->
                <div x-show="!votoExitoso" class="bg-gray-50 px-6 py-3 flex justify-end gap-3 border-t">
                    <button @click="cerrarModal()" 
                            x-show="!procesando"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Cancelar
                    </button>
                    <button @click="confirmarVoto()" 
                            x-show="!procesando"
                            :disabled="procesando" 
                            class="px-4 py-2 bg-azulOscuro text-white rounded-md hover:bg-[#1d214d] disabled:opacity-50">
                        Emitir Voto
                    </button>
                </div>
            </div>
        </div>

        <!-- Toast de éxito -->
        <div x-show="toastVisible" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-20"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-20"
             class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>¡Voto emitido correctamente!</span>
        </div>
    </div>

    <script>
        function votacionApp() {
            return {
                tiempoRestante: 'Cargando...',
                horaFin: '{{ $data['votacion']['hora_fin'] }}',
                modalAbierto: false,
                procesando: false,
                toastVisible: false,
                votoExitoso: false,
                
                iniciarContador() {
                    const actualizarTiempo = () => {
                        const ahora = new Date();
                        const [horasFin, minutosFin] = this.horaFin.split(':').map(Number);
                        
                        const fin = new Date();
                        fin.setHours(horasFin, minutosFin, 0);
                        
                        if (fin < ahora) {
                            this.tiempoRestante = '00:00:00';
                            // Redirigir si el tiempo ha terminado
                            // window.location.href = '/votacion';
                            return;
                        }
                        
                        const diff = fin - ahora;
                        const horas = Math.floor(diff / 3600000);
                        const minutos = Math.floor((diff % 3600000) / 60000);
                        const segundos = Math.floor((diff % 60000) / 1000);
                        
                        this.tiempoRestante = `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
                    };
                    
                    actualizarTiempo();
                    setInterval(actualizarTiempo, 1000);
                },
                
                verificarSeleccion() {
                    const presidenteVoto = document.querySelector('input[name="presidente"]:checked');
                    const directorVoto = document.querySelector('input[name="director"]:checked');

                    if (!presidenteVoto || !directorVoto) {
                        alert('Debe seleccionar un candidato para cada cargo o votar en blanco');
                        return;
                    }

                    // Mostrar información en el modal
                    const presidenteContainer = document.getElementById('presidenteSeleccionado');
                    const directorContainer = document.getElementById('directorSeleccionado');
                    
                    presidenteContainer.innerHTML = '';
                    directorContainer.innerHTML = '';
                    
                    if (presidenteVoto.value === 'blanco') {
                        presidenteContainer.innerHTML = `
                            <div class="bg-white p-3 rounded-md border w-full">
                                <p class="font-medium text-center">Voto en Blanco</p>
                            </div>
                        `;
                    } else {
                        const label = document.querySelector(`label[for="presidente_${presidenteVoto.value}"]`);
                        const nombre = label.querySelector('h3').textContent.trim();
                        const foto = label.querySelector('img')?.src || '';
                        
                        presidenteContainer.innerHTML = `
                            <div class="bg-white p-3 rounded-md border flex items-center gap-3 w-full">
                                ${foto ? `<img src="${foto}" class="w-12 h-12 rounded-full object-cover">` : ''}
                                <p class="font-medium">${nombre}</p>
                            </div>
                        `;
                    }
                    
                    if (directorVoto.value === 'blanco') {
                        directorContainer.innerHTML = `
                            <div class="bg-white p-3 rounded-md border w-full">
                                <p class="font-medium text-center">Voto en Blanco</p>
                            </div>
                        `;
                    } else {
                        const label = document.querySelector(`label[for="director_${directorVoto.value}"]`);
                        const nombre = label.querySelector('h3').textContent.trim();
                        const foto = label.querySelector('img')?.src || '';
                        
                        directorContainer.innerHTML = `
                            <div class="bg-white p-3 rounded-md border flex items-center gap-3 w-full">
                                ${foto ? `<img src="${foto}" class="w-12 h-12 rounded-full object-cover">` : ''}
                                <p class="font-medium">${nombre}</p>
                            </div>
                        `;
                    }
                    
                    // Reiniciar estados
                    this.votoExitoso = false;
                    this.procesando = false;
                    
                    // Abrir el modal
                    this.modalAbierto = true;
                },
                
                cerrarModal() {
                    this.modalAbierto = false;
                },
                
                confirmarVoto() {
                    if (this.procesando) return;
                    
                    this.procesando = true;
                    const presidenteVoto = document.querySelector('input[name="presidente"]:checked');
                    const directorVoto = document.querySelector('input[name="director"]:checked');
                    
                    const votos = [
                        {
                            es_blanco: presidenteVoto.value === 'blanco',
                            candidato_id: presidenteVoto.value === 'blanco' ? null : parseInt(presidenteVoto.value)
                        },
                        {
                            es_blanco: directorVoto.value === 'blanco',
                            candidato_id: directorVoto.value === 'blanco' ? null : parseInt(directorVoto.value)
                        }
                    ];
                    
                    fetch('/votacion/procesar', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ votos })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.procesando = false;
                        
                        if (data.status === 'success') {
                            this.votoExitoso = true;
                            
                            // Redireccionar después de mostrar mensaje
                            setTimeout(() => {
                                window.location.href = '/votacion';
                            }, 3000);
                        } else {
                            alert(data.message || 'Error al emitir el voto');
                        }
                    })
                    .catch(error => {
                        this.procesando = false;
                        alert('Error al procesar la votación');
                        console.error('Error:', error);
                    });
                }
            }
        }
    </script>
</body>
</html>
