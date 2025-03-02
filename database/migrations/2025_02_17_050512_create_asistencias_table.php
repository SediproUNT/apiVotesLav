<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained()->onDelete('cascade');
            $table->foreignId('sediprano_id')->constrained()->onDelete('cascade');
            $table->datetime('hora_registro');
            $table->enum('estado', ['presente', 'tardanza', 'falta']);
            $table->text('observacion')->nullable();
            $table->timestamps();

            // Un sediprano solo puede tener una asistencia por evento
            $table->unique(['evento_id', 'sediprano_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('asistencias');
    }
};
