<?php

namespace Database\Seeders;

use App\Models\Evento;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $eventos = [
            [
                'nombre' => 'Elecciones Sedipranas 2025',
                'descripcion' => 'Elecciones de representantes de Sedipranos 2025',
                'fecha' => '2025-03-08',
                'hora_inicio' => '15:30',
                'hora_fin' => '16:00',
                'estado' => 'programado',
                'ubicacion' => 'Paraninfo Institucional” de Local Central de la UNT'
            ],
            // [
            //     'nombre' => 'Evento Prueba',
            //     'descripcion' => 'Descripción del evento',
            //     'fecha' => now()->format('Y-m-d'),
            //     'hora_inicio' => now()->format('H:i'),
            //     'hora_fin' => now()->addHours(4)->format('H:i'),
            //     'estado' => 'en_curso',
            //     'ubicacion' => 'Local'
            // ],
        ];

        foreach ($eventos as $evento) {
            Evento::create($evento);
        }
    }
}
