<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sedipranos', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo')->unique();
            $table->string('dni', 8)->nullable();
            $table->string('primer_apellido');
            $table->string('segundo_apellido');
            $table->string('carrera')->nullable();
            $table->string('celular', 9)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->foreignId('user_id')->unique()->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sedipranos');
    }
};
