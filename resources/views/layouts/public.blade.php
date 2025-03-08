<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SEDIPRO UNT</title>
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
<body class="bg-gray-50">
    <div x-data="{ menuOpen: false, dropdown: false }">
        <!-- Navbar -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <img class="h-10 w-auto" src="https://storage.googleapis.com/imagenes_bananos/votes/logos/logo-sedipro.png" alt="SEDIPRO">
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('public.dashboard') }}" class="border-transparent text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('public.dashboard') ? 'border-azul text-azul' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('public.sedipranos') }}" class="border-transparent text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('public.sedipranos*') ? 'border-azul text-azul' : '' }}">
                                Sedipranos
                            </a>
                            <a href="{{ route('public.asistencias') }}" class="border-transparent text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('public.asistencias*') ? 'border-azul text-azul' : '' }}">
                                Asistencias
                            </a>
                            <a href="{{ route('public.eventos') }}" class="border-transparent text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('public.eventos*') ? 'border-azul text-azul' : '' }}">
                                Eventos
                            </a>
                            <a href="{{ route('panel.votaciones.index') }}" class="border-transparent text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('panel.votaciones.*') ? 'border-azul text-azul' : '' }}">
                                Votaciones
                            </a>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-azul" type="button">
                                    <span class="sr-only">Abrir menú de usuario</span>
                                    <div class="h-8 w-8 rounded-full bg-azulOscuro flex items-center justify-center text-white font-bold">
                                        +
                                    </div>
                                </button>
                            </div>
                            <div x-show="open" 
                                 @click.away="open = false"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" 
                                 role="menu">
                                <a href="{{ route('public.sedipranos.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Nuevo Sediprano</a>
                                <a href="{{ route('public.eventos.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Nuevo Evento</a>
                                <a href="{{ route('public.escanear-qr') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Escanear QR</a>
                            </div>
                        </div>
                    </div>
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="menuOpen = !menuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-azul">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div x-show="menuOpen" class="sm:hidden" id="mobile-menu">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('public.dashboard') }}" class="text-gray-600 hover:bg-gray-50 hover:text-azul block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('public.dashboard') ? 'border-azul text-azul bg-azul/5' : 'border-transparent' }} text-base font-medium">
                        Dashboard
                    </a>
                    <a href="{{ route('public.sedipranos') }}" class="text-gray-600 hover:bg-gray-50 hover:text-azul block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('public.sedipranos*') ? 'border-azul text-azul bg-azul/5' : 'border-transparent' }} text-base font-medium">
                        Sedipranos
                    </a>
                    <a href="{{ route('public.asistencias') }}" class="text-gray-600 hover:bg-gray-50 hover:text-azul block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('public.asistencias*') ? 'border-azul text-azul bg-azul/5' : 'border-transparent' }} text-base font-medium">
                        Asistencias
                    </a>
                    <a href="{{ route('public.eventos') }}" class="text-gray-600 hover:bg-gray-50 hover:text-azul block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('public.eventos*') ? 'border-azul text-azul bg-azul/5' : 'border-transparent' }} text-base font-medium">
                        Eventos
                    </a>
                    <a href="{{ route('panel.votaciones.index') }}" class="text-gray-600 hover:bg-gray-50 hover:text-azul block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('panel.votaciones.*') ? 'border-azul text-azul bg-azul/5' : 'border-transparent' }} text-base font-medium">
                        Votaciones
                    </a>
                    <div class="border-t border-gray-200 pt-4">
                        <div class="px-2 space-y-1">
                            <a href="{{ route('public.sedipranos.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-azul hover:bg-gray-50">
                                Nuevo Sediprano
                            </a>
                            <a href="{{ route('public.eventos.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-azul hover:bg-gray-50">
                                Nuevo Evento
                            </a>
                            <a href="{{ route('public.escanear-qr') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-azul hover:bg-gray-50">
                                Escanear QR
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-xl font-bold text-azulOscuro">
                    @yield('header-title', 'Panel Público SEDIPRO')
                </h1>
            </div>
        </header>

        <!-- Main content -->
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @if (session('success'))
                <div class="mb-4 bg-green-50 text-green-700 p-4 rounded-md flex items-center">
                    <svg class="h-5 w-5 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                @endif
                
                @if (session('error'))
                <div class="mb-4 bg-red-50 text-red-700 p-4 rounded-md flex items-center">
                    <svg class="h-5 w-5 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
                @endif
                
                @yield('content')
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center md:flex-row md:justify-between">
                    <div class="mb-6 md:mb-0">
                        <img src="https://storage.googleapis.com/imagenes_bananos/votes/logos/logo-sedipro.png" alt="SEDIPRO" class="h-10">
                    </div>
                    <div class="flex flex-col items-center md:items-end">
                        <p class="text-sm text-gray-500">&copy; {{ date('Y') }} SEDIPRO UNT</p>
                        <p class="text-sm text-gray-500 mt-1">Panel Público de Información</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
