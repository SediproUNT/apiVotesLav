<?php

use App\Enums\EstadoVotacion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('votaciones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->text('descripcion')->nullable();
            // $table->string('estado', 20)->default('pendiente');
            $table->enum('estado', array_column(EstadoVotacion::cases(), 'value'));
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('votaciones');
    }
};
