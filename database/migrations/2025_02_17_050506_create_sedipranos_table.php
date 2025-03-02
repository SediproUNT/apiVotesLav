<?php

use App\Enums\Genero;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('sedipranos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('codigo')->unique();
            $table->string('dni', 8)->nullable();
            $table->string('primer_apellido');
            $table->string('segundo_apellido');
            $table->foreignId('carrera_id')->nullable()->constrained('carreras'); // Relación con carreras
            $table->enum('genero', array_column(Genero::cases(), 'value'));
            $table->string('celular', 9)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->foreignId('user_id')->unique()->constrained('users');
            $table->foreignId('cargo_id')->constrained();  // Cargo actual
            $table->foreignId('area_id')->nullable()->constrained(); // Área actual
            $table->string('qr_code')->nullable();
            $table->string('qr_path')->nullable(); // Agregamos este campo
            $table->string('secret_key')->nullable(); // Clave secreta única
            $table->string('token')->nullable();      // Token UUID
            $table->string('qr_hash')->nullable();    // Hash HMAC del QR
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sedipranos');
    }
};
