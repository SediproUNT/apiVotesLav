<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sediprano_id')->constrained();
            $table->date('fecha');
            $table->time('hora_ingreso');
            $table->string('estado', 20)->default('presente');
            $table->boolean('participacion')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asistencias');
    }
};
