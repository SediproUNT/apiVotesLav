@extends('layouts.public')

@section('title', 'Perfil de Sediprano')

@section('header-title', 'Perfil de Miembro')

@section('content')
<div class="mb-4">
    <a href="{{ route('public.sedipranos') }}" class="inline-flex items-center text-sm text-azul hover:text-azul-dark">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Volver a lista de miembros
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Información del perfil -->
    <div class="md:col-span-1">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-azul to-azulOscuro p-6 flex flex-col items-center">
                <div class="w-24 h-24 rounded-full bg-white text-azulOscuro flex items-center justify-center text-4xl font-bold mb-4">
                    {{ substr($sediprano->user->name, 0, 1) }}
                </div>
                <h2 class="text-xl font-semibold text-white text-center">{{ $sediprano->user->name }}</h2>
                <div class="mt-2 px-3 py-1 bg-white/20 text-white text-sm rounded-full">
                    {{ $sediprano->cargo->nombre ?? 'Sin cargo' }}
                </div>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Código</p>
                        <p class="text-base text-gray-900">{{ $sediprano->codigo }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">DNI</p>
                        <p class="text-base text-gray-900">{{ $sediprano->dni }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">Área</p>
                        <p class="text-base text-gray-900">{{ $sediprano->area->nombre ?? 'Sin área' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">Carrera</p>
                        <p class="text-base text-gray-900">{{ $sediprano->carrera->nombre ?? 'Sin carrera' }}</p>
                    </div>
                    
                    @if($sediprano->fecha_nacimiento)
                    <div>
                        <p class="text-sm font-medium text-gray-500">Fecha de nacimiento</p>
                        <p class="text-base text-gray-900">{{ \Carbon\Carbon::parse($sediprano->fecha_nacimiento)->format('d/m/Y') }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">Miembro desde</p>
                        <p class="text-base text-gray-900">{{ \Carbon\Carbon::parse($sediprano->created_at)->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Historial de asistencias -->
    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Historial de Asistencias</h2>
            
            @if($sediprano->asistencias->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evento</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sediprano->asistencias as $asistencia)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $asistencia->evento->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($asistencia->evento->fecha)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($asistencia->hora_registro)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Estadísticas de asistencia -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Estadísticas de asistencia</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">Total Asistencias</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $sediprano->asistencias->count() }}</p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">Asistencias a tiempo</p>
                            <p class="text-2xl font-bold text-green-600">{{ $sediprano->asistencias->where('estado', 'presente')->count() }}</p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-500">Tardanzas</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $sediprano->asistencias->where('estado', 'tardanza')->count() }}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-md">
                    <p>Este miembro aún no tiene registros de asistencia.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
