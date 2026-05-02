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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index(); // Unique + Indexé pour éviter doublons et améliorer recherche
            $table->text('description')->nullable();
            $table->enum('level', ['beginner', 'intermediate', 'advanced', 'expert']);
            $table->boolean('is_active')->default(true); // Ajout: Soft delete alternatif (désactiver sans supprimer)
            $table->string('icon')->nullable(); // Ajout: Icône du skill (Bootstrap Icons, Font Awesome, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
