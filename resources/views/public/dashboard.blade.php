@extends('layouts.public')

@section('title', 'Dashboard')

@section('header-title', 'Dashboard Público SEDIPRO')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-azul/10 p-3 rounded-md">
                <svg class="h-6 w-6 text-azul" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="ml-5">
                <h3 class="text-lg font-medium text-gray-700">Total Miembros</h3>
                <div class="text-2xl font-bold text-gray-900">{{ $totalSedipranos }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-morado/10 p-3 rounded-md">
                <svg class="h-6 w-6 text-morado" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="ml-5">
                <h3 class="text-lg font-medium text-gray-700">Total Eventos</h3>
                <div class="text-2xl font-bold text-gray-900">{{ $totalEventos }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-azulOscuro/10 p-3 rounded-md">
                <svg class="h-6 w-6 text-azulOscuro" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-5">
                <h3 class="text-lg font-medium text-gray-700">Total Asistencias</h3>
                <div class="text-2xl font-bold text-gray-900">{{ $totalAsistencias }}</div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-azulOscuro mb-4">Asistencia por Área</h2>
        <div class="space-y-4">
            @foreach($asistenciasPorArea as $asistencia)
                <div class="flex items-center">
                    <span class="w-32 text-gray-600">{{ $asistencia->nombre }}</span>
                    <div class="flex-grow bg-gray-200 rounded-full h-2.5">
                        <div class="bg-azul h-2.5 rounded-full" style="width: {{ ($asistencia->total / $totalAsistencias) * 100 }}%"></div>
                    </div>
                    <span class="w-16 text-right text-gray-600 ml-2">{{ $asistencia->total }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-azulOscuro mb-4">Próximos Eventos</h2>
        @if($proximosEventos->count() > 0)
            <div class="space-y-4">
                @foreach($proximosEventos as $evento)
                    <div class="border-l-4 border-morado pl-4 py-2">
                        <h3 class="font-medium text-gray-800">{{ $evento->nombre }}</h3>
                        <div class="flex items-center text-sm text-gray-600 mt-1">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</span>
                            <span class="mx-2">•</span>
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $evento->hora_inicio }} - {{ $evento->hora_fin }}</span>
                        </div>
                        @if($evento->lugar)
                            <div class="flex items-center text-sm text-gray-600 mt-1">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $evento->lugar }}</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No hay eventos próximos programados</p>
        @endif
    </div>
</div>

<div class="mt-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-azulOscuro mb-4">Acceso Rápido</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('public.sedipranos') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-md">
                <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-md bg-azul text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <div class="text-gray-800 font-medium">Ver Miembros</div>
                    <div class="text-xs text-gray-500">Lista de sedipranos</div>
                </div>
            </a>
            <a href="{{ route('public.asistencias') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-md">
                <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-md bg-morado text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <div class="text-gray-800 font-medium">Asistencias</div>
                    <div class="text-xs text-gray-500">Control de asistencia</div>
                </div>
            </a>
            <a href="{{ route('public.eventos') }}" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-md">
                <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-md bg-azulOscuro text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <div class="text-gray-800 font-medium">Eventos</div>
                    <div class="text-xs text-gray-500">Calendario de eventos</div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
