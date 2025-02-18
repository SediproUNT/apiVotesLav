<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sediprano_id')->constrained(); // Sediprano que postula
            $table->foreignId('cargo_id')->constrained();  // Cargo al que postula
            $table->foreignId('area_id')->nullable()->constrained(); // Área al que postula (si aplica)
            $table->foreignId('votacion_id')->constrained('votaciones'); // A qué votación pertenece
            $table->string('foto')->nullable(); // Foto opcional
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidatos');
    }
};
