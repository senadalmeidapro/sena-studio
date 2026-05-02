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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();  // Indexé pour recherche/filtrage
            $table->string('slug')->unique(); // Obligatoire pour URLs (pas nullable)
            $table->text('description')->nullable(); // Ajout: champ manquant
            $table->integer('sort_order')->default(0); // Ajout: pour tri/classement
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
