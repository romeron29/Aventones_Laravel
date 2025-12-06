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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id(); // id_reserva INT AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('ride_id')->constrained('rides')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('pasajero_id')->constrained('usuarios')->onDelete('cascade')->onUpdate('cascade');
            // $table->timestamps() ya maneja created_at y updated_at, similar a fecha_reserva y fecha_actualizacion
            $table->enum('estado', ['pendiente', 'aceptada', 'rechazada', 'cancelada'])->default('pendiente');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
