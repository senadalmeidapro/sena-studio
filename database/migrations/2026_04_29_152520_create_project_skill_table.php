<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * NOUVELLE: Relation Many-to-Many entre Projects et Skills
     * Permet d'associer plusieurs skills à un projet et vice-versa
     */
    public function up(): void
    {
        Schema::create('project_skill', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                ->constrained('projects')
                ->onDelete('cascade');

            $table->foreignId('skill_id')
                ->constrained('skills')
                ->onDelete('cascade');

            // Niveau d'utilisation du skill pour ce projet
            $table->enum('proficiency', [
                'primary',      // Skill principal du projet
                'secondary',    // Support/optionnel
                'research',      // En apprentissage/exploration
            ])->default('secondary');

            $table->timestamps();

            // Contrainte: Un skill ne peut être associé qu'une fois par projet
            $table->unique(['project_id', 'skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_skill');
    }
};
