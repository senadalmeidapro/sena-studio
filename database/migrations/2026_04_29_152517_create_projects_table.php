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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Informations de base
            $table->string('name')->index(); // Indexé pour recherche
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Métadonnées
            $table->string('version')->default('1.0.0'); // CHANGÉ: decimal → string (sémantic versioning)
            $table->decimal('price', 10, 2)->default(0.00);

            // Ressources
            $table->string('url')->nullable();
            $table->string('repository_url')->nullable();
            $table->string('image')->nullable();

            // Statuts (Enum)
            $table->enum('status', ['development', 'testing', 'production', 'cancelled'])->default('development');
            $table->enum('type', ['web', 'app', 'software'])->default('web');
            $table->enum('complexity', ['simple', 'medium', 'complex'])->default('simple');
            $table->enum('visibility', ['public', 'private', 'protected'])->default('public');

            // Timeline
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();

            // AJOUT: Relations vers infrastructure
            $table->foreignId('stack_id')
                ->nullable()
                ->constrained('stacks')
                ->onDelete('set null');

            $table->foreignId('infra_id')
                ->nullable()
                ->constrained('infras')
                ->onDelete('set null');

            // Soft Delete & Timestamps
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
