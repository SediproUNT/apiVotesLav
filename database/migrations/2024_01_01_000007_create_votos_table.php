<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('votos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sediprano_id')->constrained();
            $table->foreignId('candidato_id')->constrained();
            $table->foreignId('votacion_id')->constrained('votaciones');
            $table->timestamp('fecha_voto')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('votos');
    }
};
