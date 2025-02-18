<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('votaciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->text('descripcion')->nullable();
            $table->string('estado', 20)->default('pendiente'); // Pendiente, En curso, Finalizada
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('votaciones');
    }
};
