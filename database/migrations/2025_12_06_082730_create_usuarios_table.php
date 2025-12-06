<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // id_usuario INT AUTO_INCREMENT PRIMARY KEY
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('cedula', 20)->unique();
            $table->date('fecha_nacimiento');
            $table->string('correo', 100)->unique();
            $table->string('telefono', 25)->nullable();
            $table->string('fotografia')->nullable();
            $table->string('contrasenna'); // Usar $table->string('password'); si vas a usar el sistema Auth de Laravel
            $table->enum('tipo_usuario', ['administrador', 'chofer', 'pasajero'])->default('pasajero');
            $table->enum('estado', ['pendiente', 'activo', 'inactivo'])->default('pendiente');
            $table->timestamps(); // Crea created_at (similar a fecha_creacion) y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
