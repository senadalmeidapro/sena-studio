<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * OPTION A (RECOMMANDÉE): Many-to-Many Flexible
     * Cette approche permet d'ajouter des technologies sans migration.
     * Idéale pour une application évolutive.
     */
    public function up(): void
    {
        // Table maître des stacks
        Schema::create('stacks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // NOUVEAU: Composants du stack (flexible et maintenable)
        Schema::create('stack_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stack_id')
                ->constrained('stacks')
                ->onDelete('cascade');

            // Catégorie du composant
            $table->enum('category', [
                'frontend',      // React, Vue, Angular, Svelte, etc.
                'backend',       // Laravel, NestJS, Django, etc.
                'database',      // MySQL, PostgreSQL, MongoDB, SQLite, etc.
                'cache',         // Redis, Memcached
                'queue',         // Redis, SQS, RabbitMQ
                'orm',           // Eloquent, Prisma, Sequelize, TypeORM
                'storage',       // CORRIGÉ: "storage" au lieu de "stockage"
                'cloud',         // AWS, Railway, Vercel, Netlify
            ]);

            // Valeur du composant
            $table->string('value')->index();
            $table->string('version')->nullable(); // ex: "5.0.0"

            $table->timestamps();

            // Contrainte: pas de doublon exact (même valeur pour la même catégorie du même stack)
            // (retrait de l'ancienne contrainte unique(['stack_id','category']) qui empêchait
            // d'avoir plusieurs technologies dans une même catégorie, ex: deux outils "backend")
            $table->unique(['stack_id', 'category', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stack_items');
        Schema::dropIfExists('stacks');
    }
};
