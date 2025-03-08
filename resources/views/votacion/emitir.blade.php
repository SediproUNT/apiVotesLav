<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Emisión de Voto - SEDIPRO</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full bg-gradient-to-b from-muted/50 to-background">
    <div class="min-h-screen p-6">
        <!-- Header con info del votante -->
        <div class="max-w-7xl mx-auto mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h5 class="text-xl font-semibold mb-2">Bienvenido(a), {{ $data['sediprano']['user']['name'] }}</h5>
                <p class="text-gray-600">Código: {{ $data['sediprano']['codigo'] }}</p>
                <p class="text-gray-600">Área: {{ $data['sediprano']['area']['nombre'] }}</p>
            </div>
        </div>

        <!-- Contenedor de candidatos -->
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Candidatos a Presidente -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h5 class="text-lg font-semibold">Candidatos a Presidente</h5>
                </div>
                <div class="p-6 space-y-4">
                    @foreach($data['candidatos']['presidencia'] as $candidato)
                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                        <label class="flex items-start space-x-4 cursor-pointer">
                            <input type="radio" name="presidente" value="{{ $candidato['id'] }}"
                                   class="mt-1 h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <div class="flex-1">
                                <strong class="block text-gray-900">
                                    {{ $candidato['nombres'] }} {{ $candidato['primer_apellido'] }} {{ $candidato['segundo_apellido'] }}
                                </strong>
                                @if($candidato['foto'])
                                <img src="{{ $candidato['foto'] }}" alt="Foto candidato" class="mt-2 rounded-lg max-w-[200px]">
                                @endif
                            </div>
                        </label>
                    </div>
                    @endforeach
                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                        <label class="flex items-center space-x-4 cursor-pointer">
                            <input type="radio" name="presidente" value="blanco"
                                   class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <strong class="text-gray-900">Voto en Blanco</strong>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Candidatos a Director -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-green-600 text-white px-6 py-4">
                    <h5 class="text-lg font-semibold">Candidatos a Director de Área</h5>
                </div>
                <div class="p-6 space-y-4">
                    @foreach($data['candidatos']['area'] as $candidato)
                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                        <label class="flex items-start space-x-4 cursor-pointer">
                            <input type="radio" name="director" value="{{ $candidato['id'] }}"
                                   class="mt-1 h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500">
                            <div class="flex-1">
                                <strong class="block text-gray-900">
                                    {{ $candidato['nombres'] }} {{ $candidato['primer_apellido'] }} {{ $candidato['segundo_apellido'] }}
                                </strong>
                                @if($candidato['foto'])
                                <img src="{{ $candidato['foto'] }}" alt="Foto candidato" class="mt-2 rounded-lg max-w-[200px]">
                                @endif
                            </div>
                        </label>
                    </div>
                    @endforeach
                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                        <label class="flex items-center space-x-4 cursor-pointer">
                            <input type="radio" name="director" value="blanco"
                                   class="h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500">
                            <strong class="text-gray-900">Voto en Blanco</strong>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de emisión de voto -->
        <div class="max-w-7xl mx-auto mt-8">
            <button id="btnEmitirVoto" 
                class="w-full bg-blue-600 text-white py-4 px-6 rounded-lg text-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/50 disabled:opacity-50 disabled:cursor-not-allowed">
                Emitir Voto
            </button>
        </div>
    </div>

    <script>
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
