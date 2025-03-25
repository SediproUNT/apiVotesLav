<?php

namespace Database\Seeders;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CarrerasSeeder::class,
            CargosSeeder::class,
            AreasSeeder::class,
            UserSeeder::class,
            SedipranoSeeder::class,
            VotacionSeeder::class,
            CandidatoSeeder::class,
            EventoSeeder::class,
        ]);

        // Resetear todas las secuencias después de sembrar
        // $this->resetPostgresSequences();
    }

    // private function resetPostgresSequences()
    // {
    //     // Lista de tablas que necesitan reset de secuencia
    //     $tables = ['areas', 'cargos','votaciones', 'candidatos', 'sedipranos', 'votos', 'carreras', 'users', 'eventos', 'asistencias'];

    //     foreach ($tables as $table) {
    //         // Obtener el máximo ID y resetear la secuencia
    //         $max = DB::table($table)->max('id') ?? 0;
    //         DB::statement("ALTER SEQUENCE {$table}_id_seq RESTART WITH " . ($max + 1));
    //     }
    // }
}
