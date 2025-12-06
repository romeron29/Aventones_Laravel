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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id(); // id_vehiculo INT AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('chofer_id')->constrained('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->string('placa', 15)->unique();
            $table->string('marca', 25);
            $table->string('modelo', 50);
            $table->integer('anno');
            $table->string('color', 30)->nullable();
            $table->integer('capacidad_asientos');
            $table->string('fotografia')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
