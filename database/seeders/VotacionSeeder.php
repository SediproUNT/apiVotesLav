<?php

namespace Database\Seeders;

use App\Models\Votacion;
use App\Enums\EstadoVotacion;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VotacionSeeder extends Seeder
{
    public function run(): void
    {
        // Establecer explícitamente la zona horaria
        $fecha = Carbon::create(2025, 3, 8)->setTimezone('America/Lima');

        Votacion::create([
            'name' => 'Elecciones Sedipranas 2025',
            'fecha' => $fecha->toDateString(),
            'hora_inicio' => '17:00',  // Formato simplificado ya que el modelo maneja el casting
            'hora_fin' => '17:10',     // Formato simplificado ya que el modelo maneja el casting
            'descripcion' => 'Votación para elegir a los nuevos representantes de Sedipro',
            'estado' => EstadoVotacion::Pendiente
        ]);

        // Si necesitas más votaciones de prueba:
        // Votacion::create([
        //     'name' => 'Votación de Prueba',
        //     'fecha' => Carbon::today()->toDateString(),
        //     'hora_inicio' => Carbon::now()->format('H:i'),
        //     'hora_fin' => Carbon::now()->addHours(2)->format('H:i'),
        //     'descripcion' => 'Votación de Prueba Actual',
        //     'estado' => EstadoVotacion::Pendiente  // El modelo actualizará automáticamente el estado según la hora
        // ]);
    }
}
