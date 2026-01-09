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
        Schema::create('menus', function (Blueprint $table) {
        $table->id();
        // Relación: Quién crea el menú
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Relación: Qué plato añade
        $table->foreignId('dish_id')->constrained()->onDelete('cascade');
        
        // El dato clave: La fecha
        $table->date('date');
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
