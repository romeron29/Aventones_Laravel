<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// Migración para la tabla de rides
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade'); 
            
            $table->string('name'); 
            $table->string('origin');
            $table->string('destination');
            $table->dateTime('departure_time');
            $table->decimal('cost', 8, 2);
            $table->integer('seats_available'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};