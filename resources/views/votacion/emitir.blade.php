<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Emisión de Voto - SEDIPRO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-gray-50" x-data="votacionApp()">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <img src="https://storage.googleapis.com/imagenes_bananos/votes/logos/logo-sedipro.png" 
                     alt="SEDIPRO UNT" class="w-20">
                <div class="text-lg font-semibold text-purple-600" x-text="tiempoRestante">
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

            <h1 class="text-2xl md:text-3xl font-bold text-purple-700 mb-2">
                Votación para elegir a los nuevos representantes de Sedipro
            </h1>
            <p class="text-gray-500">
                {{ \Carbon\Carbon::parse($data['votacion']['fecha'])->format('d/m/Y') }} - 
                Hora: {{ $data['votacion']['hora_inicio'] }} a {{ $data['votacion']['hora_fin'] }}
            </p>
        </header>

        <!-- Secciones de Votación -->
        <div class="space-y-8">
            <!-- Presidente -->
            <section>
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-xl font-semibold text-purple-600">Candidatos a Presidente</h2>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($data['candidatos']['presidencia'] as $index => $candidato)
                    <div class="relative">
                        <input type="radio" name="presidente" id="presidente_{{ $candidato['id'] }}" 
                               value="{{ $candidato['id'] }}" class="peer hidden" required>
                        <label for="presidente_{{ $candidato['id'] }}" 
                               class="block p-6 bg-white rounded-lg shadow-sm border border-gray-200
                                      peer-checked:bg-purple-50 peer-checked:border-purple-500 
                                      transition-all cursor-pointer">
                            <div class="absolute top-4 left-4 w-8 h-8 flex items-center justify-center
                                      bg-purple-100 text-purple-700 rounded-full font-semibold">
                                {{ chr(65 + $index) }}
                            </div>
                            <div class="flex flex-col items-center">
                                @if($candidato['foto'])
                                    <img src="{{ $candidato['foto'] }}" alt="Foto candidato" 
                                         class="w-32 h-32 rounded-full object-cover mb-4">
                                @else
                                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mb-4">
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
                                <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                      peer-checked:bg-purple-50 peer-checked:border-purple-500 
                                      transition-all cursor-pointer">
                            <div class="flex flex-col items-center">
                                <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                              d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold">Voto en Blanco</h3>
                            </div>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Director de Área -->
            <section>
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h2 class="text-xl font-semibold text-purple-600">
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
                                      peer-checked:bg-purple-50 peer-checked:border-purple-500 
                                      transition-all cursor-pointer">
                            <div class="absolute top-4 left-4 w-8 h-8 flex items-center justify-center
                                      bg-purple-100 text-purple-700 rounded-full font-semibold">
                                {{ chr(65 + $index) }}
                            </div>
                            <div class="flex flex-col items-center">
                                @if($candidato['foto'])
                                    <img src="{{ $candidato['foto'] }}" alt="Foto candidato" 
                                         class="w-32 h-32 rounded-full object-cover mb-4">
                                @else
                                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mb-4">
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
                                <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                      peer-checked:bg-purple-50 peer-checked:border-purple-500 
                                      transition-all cursor-pointer">
                            <div class="flex flex-col items-center">
                                <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                              d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold">Voto en Blanco</h3>
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
                    class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 
                           focus:outline-none focus:ring-4 focus:ring-purple-500/50">
                Emitir Voto
            </button>
        </footer>

        <div class="mt-4 text-center text-sm text-gray-500">
            <p>Votaciones Sedipranas 2025</p>
            <p class="mt-1">Si tienes problemas para votar, contacta al área de TI</p>
        </div>
    </div>

    <script>
        function votacionApp() {
            return {
                tiempoRestante: '',
                horaFin: '{{ $data['votacion']['hora_fin'] }}',
                iniciarContador() {
                    const actualizarTiempo = () => {
                        const ahora = new Date();
                        const fin = new Date();
                        const [horas, minutos] = this.horaFin.split(':');
                        fin.setHours(horas, minutos, 0);

                        if (fin < ahora) {
                            this.tiempoRestante = '00:00:00';
                            window.location.href = '/votacion';
                            return;
                        }

                        const diff = fin - ahora;
                        const h = Math.floor(diff / 3600000);
                        const m = Math.floor((diff % 3600000) / 60000);
                        const s = Math.floor((diff % 60000) / 1000);

                        this.tiempoRestante = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                    };

                    actualizarTiempo();
                    setInterval(actualizarTiempo, 1000);
                }
            }
        }

        document.getElementById('btnEmitirVoto').addEventListener('click', async function() {
            if (!confirm('¿Está seguro de emitir su voto? Esta acción no se puede deshacer.')) {
                return;
            }

            const presidenteVoto = document.querySelector('input[name="presidente"]:checked');
            const directorVoto = document.querySelector('input[name="director"]:checked');

            if (!presidenteVoto || !directorVoto) {
                alert('Debe seleccionar un candidato para cada cargo o votar en blanco');
                return;
            }

            try {
                document.getElementById('btnEmitirVoto').disabled = true;
                
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

                const response = await fetch('/votacion/procesar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ votos })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    alert('¡Voto emitido correctamente!');
                    window.location.href = '/votacion'; // Corregir la URL de redirección
                } else {
                    alert(data.message || 'Error al emitir el voto');
                    document.getElementById('btnEmitirVoto').disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al procesar la votación');
                document.getElementById('btnEmitirVoto').disabled = false;
            }
        });
    </script>
</body>
</html>
