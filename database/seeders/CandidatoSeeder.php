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
            //Presidencia
            [
                'sediprano_id' => 76,
                'cargo_id' => 1,
                'area_id' => NULL,
                'votacion_id' => 1,
                'foto' => NULL,
            ],
            [
                'sediprano_id' => 78,
                'cargo_id' => 1,
                'area_id' => NULL,
                'votacion_id' => 1,
                'foto' => NULL,
            ],
            //PMO
            [
                'sediprano_id' => 77,
                'cargo_id' => 2,
                'area_id' => 1,
                'votacion_id' => 1,
                'foto' => NULL,
            ],
            // [
            //     'sediprano_id' => 78,
            //     'cargo_id' => 2,
            //     'area_id' => 1,
            //     'votacion_id' => 1,
            //     'foto' => NULL,
            // ]
            //-----
            [
                'sediprano_id' => 89,
                'cargo_id' => 2,
                'area_id' => 4,
                'votacion_id' => 1,
                'foto' => NULL,
            ],
            [
                'sediprano_id' => 2,
                'cargo_id' => 2,
                'area_id' => 5,
                'votacion_id' => 1,
                'foto' => NULL,
            ],
            [
                'sediprano_id' => 5,
                'cargo_id' => 2,
                'area_id' => 5,
                'votacion_id' => 1,
                'foto' => NULL,
            ],
            [
                'sediprano_id' => 46,
                'cargo_id' => 2,
                'area_id' => 3,
                'votacion_id' => 1,
                'foto' => NULL,
            ],
            [
                'sediprano_id' => 53,
                'cargo_id' => 2,
                'area_id' => 3,
                'votacion_id' => 1,
                'foto' => NULL,
            ],
            [
                'sediprano_id' => 26,
                'cargo_id' => 2,
                'area_id' => 2,
                'votacion_id' => 1,
                'foto' => NULL,
            ],
            [
                'sediprano_id' => 36,
                'cargo_id' => 2,
                'area_id' => 2,
                'votacion_id' => 1,
                'foto' => NULL,
            ]
        ]);
    }
}
