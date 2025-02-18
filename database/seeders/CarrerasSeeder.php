<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CarrerasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $carreras = [
            ['nombre' => 'Administración'],
            ['nombre' => 'Agronomía'],
            ['nombre' => 'Antropología'],
            ['nombre' => 'Arqueología'],
            ['nombre' => 'Arquitectura y Urbanismo'],
            ['nombre' => 'Biología Pesquera'],
            ['nombre' => 'Ciencias Biológicas'],
            ['nombre' => 'Ciencias de la Comunicación'],
            ['nombre' => 'Ciencias Políticas y Gobernabilidad'],
            ['nombre' => 'Contabilidad y Finanzas'],
            ['nombre' => 'Derecho'],
            ['nombre' => 'Economía'],
            ['nombre' => 'Educación Inicial'],
            ['nombre' => 'Educación Primaria'],
            ['nombre' => 'Educación Secundaria - Ciencias de la Matemática'],
            ['nombre' => 'Educación Secundaria - Ciencias Naturales: Física, Química y Biología'],
            ['nombre' => 'Educación Secundaria - Filosofía, Psicología y Ciencias Sociales'],
            ['nombre' => 'Educación Secundaria - Historia y Geografía'],
            ['nombre' => 'Educación Secundaria - Idiomas'],
            ['nombre' => 'Educación Secundaria - Lengua y Literatura'],
            ['nombre' => 'Enfermería'],
            ['nombre' => 'Estadística'],
            ['nombre' => 'Estomatología'],
            ['nombre' => 'Farmacia y Bioquímica'],
            ['nombre' => 'Física'],
            ['nombre' => 'Historia'],
            ['nombre' => 'Informática'],
            ['nombre' => 'Ingeniería Agrícola'],
            ['nombre' => 'Ingeniería Agroindustrial'],
            ['nombre' => 'Ingeniería Ambiental'],
            ['nombre' => 'Ingeniería Civil'],
            ['nombre' => 'Ingeniería de Minas'],
            ['nombre' => 'Ingeniería de Sistemas'],
            ['nombre' => 'Ingeniería Industrial'],
            ['nombre' => 'Ingeniería Mecánica'],
            ['nombre' => 'Ingeniería Mecatrónica'],
            ['nombre' => 'Ingeniería Metalúrgica'],
            ['nombre' => 'Ingeniería Química'],
            ['nombre' => 'Matemáticas'],
            ['nombre' => 'Medicina'],
            ['nombre' => 'Microbiología y Parasitología'],
            ['nombre' => 'Trabajo Social'],
            ['nombre' => 'Turismo'],
            ['nombre' => 'Zootecnia'],
        ];

        // Prepara los datos para la inserción con ID autoincrementable
        $dataToInsert = [];
        $id = 1;
        foreach ($carreras as $carrera) {
            $dataToInsert[] = [
                'id' => $id++,
                'nombre' => $carrera['nombre'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('carreras')->insert($dataToInsert);
    }
}
