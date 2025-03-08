<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Validación de Acceso - Votación</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
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
<body class="h-full bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-[450px] bg-white border border-[#E5E7EB] rounded-lg shadow-lg p-8">
            <!-- Logo y título -->
            <div class="flex flex-col items-center mb-8">
                <img src="https://storage.googleapis.com/imagenes_bananos/votes/logos/logo-sedipro.png" alt="SEDIPRO" class="h-[60px] w-auto mb-6"/>
                <h1 class="text-2xl font-bold text-azulOscuro">
                    Sistema de Votación
                </h1>
            </div>

            <!-- Formulario -->
            <form id="validacionForm" class="space-y-5">
                <div>
                    <label for="codigo" class="block text-sm font-medium text-gray-700 mb-2">
                        Código Institucional
                    </label>
                    <input type="number" id="codigo" name="codigo"
                        class="w-full h-12 px-4 text-base border border-[#D1D5DB] rounded-md 
                               focus:outline-none focus:ring-2 focus:ring-morado focus:border-morado
                               transition duration-150 ease-in-out"
                        required>
                </div>

                <div>
                    <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">
                        DNI
                    </label>
                    <input type="text" id="dni" name="dni" maxlength="8"
                        class="w-full h-12 px-4 text-base border border-[#D1D5DB] rounded-md
                               focus:outline-none focus:ring-2 focus:ring-morado focus:border-morado
                               transition duration-150 ease-in-out"
                        required>
                </div>

                <button type="submit" 
                    class="w-full h-[50px] bg-azul text-white rounded-md
                           hover:bg-azul-dark focus:outline-none focus:ring-2 focus:ring-azul/50
                           transition duration-150 ease-in-out flex items-center justify-center gap-2
                           disabled:opacity-50 disabled:cursor-not-allowed mt-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    <span class="loading hidden">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="ml-2">Validando...</span>
                    </span>
                    <span class="normal">
                        Acceder a Votación
                    </span>
                </button>

                <!-- Mensajes de error y éxito -->
                <div id="mensajeError" class="hidden mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md text-sm"></div>
                <div id="mensajeExito" class="hidden mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md text-sm"></div>

                <p class="text-sm text-center text-[#6B7280] mt-5">
                    Si tienes problemas para acceder, contacta al área de TI
                </p>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('validacionForm');
        const btnSubmit = form.querySelector('button[type="submit"]');
        const loadingSpan = btnSubmit.querySelector('.loading');
        const normalSpan = btnSubmit.querySelector('.normal');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const mensajeError = document.getElementById('mensajeError');
            const mensajeExito = document.getElementById('mensajeExito');
            mensajeError.classList.add('hidden');
            mensajeExito.classList.add('hidden');

            // Mostrar estado de carga
            btnSubmit.disabled = true;
            loadingSpan.classList.remove('hidden');
            normalSpan.classList.add('hidden');

            const formData = {
                codigo: document.getElementById('codigo').value,
                dni: document.getElementById('dni').value
            };

            try {
                const response = await fetch('/votacion/validar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (data.status === 'error') {
                    mensajeError.textContent = data.message;
                    mensajeError.classList.remove('hidden');
                    
                    // Restaurar botón
                    btnSubmit.disabled = false;
                    loadingSpan.classList.add('hidden');
                    normalSpan.classList.remove('hidden');
                } else {
                    mensajeExito.textContent = 'Acceso validado correctamente';
                    mensajeExito.classList.remove('hidden');
                    
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                }
            } catch (error) {
                mensajeError.textContent = 'Error al procesar la solicitud';
                mensajeError.classList.remove('hidden');
                
                // Restaurar botón
                btnSubmit.disabled = false;
                loadingSpan.classList.add('hidden');
                normalSpan.classList.remove('hidden');
            }
        });

        // Validación del DNI (solo números y longitud 8)
        document.getElementById('dni').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);
        });
    </script>
</body>
</html>
