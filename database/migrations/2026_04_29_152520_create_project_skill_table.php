<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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

            $table->enum('proficiency', ['primary', 'secondary', 'research'])
                ->default('secondary');

            $table->timestamps();

            $table->unique(['project_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_skill');
    }
};
