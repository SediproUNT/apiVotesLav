@extends('layouts.public')

@section('title', 'Editar Sediprano')

@section('header-title', 'Editar Miembro')

@section('content')
<div class="mb-4">
    <a href="{{ route('public.sedipranos') }}" class="inline-flex items-center text-sm text-azul hover:text-azul-dark">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Volver a lista de miembros
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold text-azulOscuro mb-6">Editar Miembro</h2>
    
    @if (session('error'))
        <div class="mb-4 bg-red-50 text-red-700 p-4 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('public.sedipranos.update', $sediprano->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código*</label>
                <input type="text" name="codigo" id="codigo" value="{{ old('codigo', $sediprano->codigo) }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                @error('codigo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI*</label>
                <input type="text" name="dni" id="dni" value="{{ old('dni', $sediprano->dni) }}" maxlength="8"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                @error('dni')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @php
                $nombreCompleto = $sediprano->user->name;
                $partes = explode(' ', $nombreCompleto);
                $nombre = '';
                $primer_apellido = $sediprano->primer_apellido;
                $segundo_apellido = $sediprano->segundo_apellido;
                
                if (count($partes) > 2) {
                    // Si hay más de 2 palabras, asumimos que la primera es el nombre
                    // y el resto son apellidos (ya almacenados en el sediprano)
                    $nombre = implode(' ', array_slice($partes, 0, count($partes) - (empty($segundo_apellido) ? 1 : 2)));
                } else {
                    // Si solo hay 1 o 2 palabras, la primera es el nombre
                    $nombre = $partes[0];
                }
            @endphp

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre(s)*</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $nombre) }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                @error('nombre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="primer_apellido" class="block text-sm font-medium text-gray-700 mb-1">Primer Apellido*</label>
                <input type="text" name="primer_apellido" id="primer_apellido" value="{{ old('primer_apellido', $primer_apellido) }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                @error('primer_apellido')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="segundo_apellido" class="block text-sm font-medium text-gray-700 mb-1">Segundo Apellido</label>
                <input type="text" name="segundo_apellido" id="segundo_apellido" value="{{ old('segundo_apellido', $segundo_apellido) }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20">
                @error('segundo_apellido')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                <input type="email" name="email" id="email" value="{{ old('email', $sediprano->user->email) }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                       value="{{ old('fecha_nacimiento', $sediprano->fecha_nacimiento ? date('Y-m-d', strtotime($sediprano->fecha_nacimiento)) : '') }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20">
                @error('fecha_nacimiento')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="carrera_id" class="block text-sm font-medium text-gray-700 mb-1">Carrera*</label>
                <select name="carrera_id" id="carrera_id" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                    <option value="">-- Seleccione una carrera --</option>
                    @foreach ($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ old('carrera_id', $sediprano->carrera_id) == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('carrera_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="area_id" class="block text-sm font-medium text-gray-700 mb-1">Área*</label>
                <select name="area_id" id="area_id" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                    <option value="">-- Seleccione un área --</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}" {{ old('area_id', $sediprano->area_id) == $area->id ? 'selected' : '' }}>
                            {{ $area->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('area_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="cargo_id" class="block text-sm font-medium text-gray-700 mb-1">Cargo*</label>
                <select name="cargo_id" id="cargo_id" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-azul focus:ring focus:ring-azul/20" required>
                    <option value="">-- Seleccione un cargo --</option>
                    @foreach ($cargos as $cargo)
                        <option value="{{ $cargo->id }}" {{ old('cargo_id', $sediprano->cargo_id) == $cargo->id ? 'selected' : '' }}>
                            {{ $cargo->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('cargo_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <form action="{{ route('public.sedipranos.destroy', $sediprano->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" 
                        onclick="return confirm('¿Estás seguro de querer eliminar este miembro? Esta acción no se puede deshacer.')">
                    Eliminar
                </button>
            </form>
            
            <button type="button" onclick="window.location.href='{{ route('public.sedipranos') }}'" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                Cancelar
            </button>
            <button type="submit" class="px-4 py-2 bg-azul text-white rounded-md hover:bg-azul-dark">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Validación para DNI (solo números)
    document.getElementById('dni').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);
    });
</script>
@endpush
