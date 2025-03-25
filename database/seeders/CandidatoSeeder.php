<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CandidatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('candidatos')->insert([

            //Presidenta
            [
                'sediprano_id' => 75, //Lucía de Fátima Amaya Cáceda
                'cargo_id' => 1,  //Presidenta
                'area_id' => NULL,
                'votacion_id' => 1,
                'foto' => 'https://storage.googleapis.com/imagenes_bananos/votes/2025/LUCIA%20DE%20FATIMA%20AMAYA%20CACEDA.JPEG',
            ],
   

            //MKT
            [
                'sediprano_id' => 44, //Angel Iparraguirre Aguilar
                'cargo_id' => 2,  //Director
                'area_id' => 3,  //Marketing
                'votacion_id' => 1,
                'foto' => 'https://storage.googleapis.com/imagenes_bananos/votes/2025/ANGEL%20IPARRAGUIRRE%20AGUILAR.png',
            ],
            [
                'sediprano_id' => 48, //Cielo Valentina Abanto Rojas
                'cargo_id' => 2,  //Director
                'area_id' => 3,  //Marketing
                'votacion_id' => 1,
                'foto' => 'https://storage.googleapis.com/imagenes_bananos/votes/2025/CIELO%20VALENTINA%20ABANTO%20ROJAS.jpeg'
            ],

            // LKT
            [
                'sediprano_id' => 24, //Diego Jesus Rodriguez Sabana
                'cargo_id' => 2,  //Director
                'area_id' => 2,  //Logística y Finanzas
                'votacion_id' => 1,
                'foto' => 'https://storage.googleapis.com/imagenes_bananos/votes/2025/DIEGO%20JESUS%20-%20DIEGO%20JESUS%20RODRIGUEZ%20SABANA.jpeg',
            ],
            [
                'sediprano_id' => 34, //Kevin Gamaliel Rodríguez Alfaro
                'cargo_id' => 2,  //Director
                'area_id' => 2,  //Logística y Finanzas
                'votacion_id' => 1,
                'foto' => 'https://storage.googleapis.com/imagenes_bananos/votes/2025/Kevin%20Rodriguez%20Alfaro%20-%20KEVIN%20GAMALIEL%20RODRIGUEZ%20ALFARO.jfif',
            ],

            //GTH
            [
                'sediprano_id' => 13, //Marina Lizeth Gonzales Torres
                'cargo_id' => 2,  //Director
                'area_id' => 5,  //Gestión de Talento Humano
                'votacion_id' => 1,
                'foto' => 'https://storage.googleapis.com/imagenes_bananos/votes/2025/FOTO%20MARINA%20GONZALES%20-%20MARINA%20LIZETH%20GONZALES%20TORRES.jpeg',
            ],

            //PMO
            [
                'sediprano_id' => 77, //María Fernanda De La Caridad Herrera Cerquin
                'cargo_id' => 2,  //Director
                'area_id' => 1,  //PMO
                'votacion_id' => 1,
                'foto' => 'https://storage.googleapis.com/imagenes_bananos/votes/2025/MARIA%20FERNANDA%20DE%20LA%20CARIDAD%20HERRERA%20CERQUIN.jpeg',
            ],
            
            //TI
            [
                'sediprano_id' => 85, //Christian Anthony Morales Esquivel
                'cargo_id' => 2,  //Director
                'area_id' => 4,  //Tecnologías de la Información
                'votacion_id' => 1,
                'foto' => 'https://storage.googleapis.com/imagenes_bananos/votes/2025/yiooo.png',
            ],



            //Presidencia
            // [
            //     'sediprano_id' => 76,
            //     'cargo_id' => 1,
            //     'area_id' => NULL,
            //     'votacion_id' => 1,
            //     'foto' => NULL,
            // ],
            // [
            //     'sediprano_id' => 78,
            //     'cargo_id' => 1,
            //     'area_id' => NULL,
            //     'votacion_id' => 1,
            //     'foto' => NULL,
            // ],
            // //PMO
            // [
            //     'sediprano_id' => 77,
            //     'cargo_id' => 2,
            //     'area_id' => 1,
            //     'votacion_id' => 1,
            //     'foto' => NULL,
            // ],
            // // [
            // //     'sediprano_id' => 78,
            // //     'cargo_id' => 2,
            // //     'area_id' => 1,
            // //     'votacion_id' => 1,
            // //     'foto' => NULL,
            // // ]
            // //-----
            // [
            //     'sediprano_id' => 89,
            //     'cargo_id' => 2,
            //     'area_id' => 4,
            //     'votacion_id' => 1,
            //     'foto' => NULL,
            // ],
            // [
            //     'sediprano_id' => 2,
            //     'cargo_id' => 2,
            //     'area_id' => 5,
            //     'votacion_id' => 1,
            //     'foto' => NULL,
            // ],
            // [
            //     'sediprano_id' => 5,
            //     'cargo_id' => 2,
            //     'area_id' => 5,
            //     'votacion_id' => 1,
            //     'foto' => NULL,
            // ],
            // [
            //     'sediprano_id' => 46,
            //     'cargo_id' => 2,
            //     'area_id' => 3,
            //     'votacion_id' => 1,
            //     'foto' => NULL,
            // ],
            // [
            //     'sediprano_id' => 53,
            //     'cargo_id' => 2,
            //     'area_id' => 3,
            //     'votacion_id' => 1,
            //     'foto' => NULL,
            // ],
            // [
            //     'sediprano_id' => 26,
            //     'cargo_id' => 2,
            //     'area_id' => 2,
            //     'votacion_id' => 1,
            //     'foto' => NULL,
            // ],
            // [
            //     'sediprano_id' => 36,
            //     'cargo_id' => 2,
            //     'area_id' => 2,
            //     'votacion_id' => 1,
            //     'foto' => NULL,
            // ]
        ]);
    }
}
