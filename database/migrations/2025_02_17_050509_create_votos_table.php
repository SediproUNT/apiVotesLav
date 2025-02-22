<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('votos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sediprano_id')->constrained(); // Quién votó
            $table->boolean('es_blanco')->default(false);
            $table->foreignId('candidato_id')->nullable()->constrained(); // A quién votó
            $table->foreignId('votacion_id')->constrained('votaciones'); // De qué votación es el voto
            $table->timestamp('fecha_voto')->useCurrent(); // Fecha y hora del voto
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('votos');
    }
};
