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
        Schema::create('tokens_activacion', function (Blueprint $table) {
            $table->id(); // id_token
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->string('token')->unique();
            $table->dateTime('fecha_expiracion')->nullable();
            $table->boolean('usado')->default(false);
            $table->timestamps(); // Crea 'created_at' (fecha_creacion) y 'updated_at'
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tokens_activacion');
    }
};
