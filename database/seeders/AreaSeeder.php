<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    public function run()
    {
        $areas = [
            [
                'nombre' => 'Project Management Office',
                'abreviatura' => 'PMO'
            ],
            [
                'nombre' => 'Logística y Finanzas',
                'abreviatura' => 'LTK Y FNZ'
            ],
            [
                'nombre' => 'Maketing',
                'abreviatura' => 'MKT'
            ],
            [
                'nombre' => 'Tecnología e Información',
                'abreviatura' => 'TI'
            ],
            [
                'nombre' => 'Gestión del Talento Humano',
                'abreviatura' => 'GTH'
            ]
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
