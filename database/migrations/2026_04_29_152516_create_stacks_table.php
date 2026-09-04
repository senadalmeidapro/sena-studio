<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stacks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('stack_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stack_id')
                ->constrained('stacks')
                ->onDelete('cascade');

            $table->enum('category', [
                'frontend',
                'backend',
                'database',
                'cache',
                'queue',
                'orm',
                'storage',
                'cloud',
                'monitoring',
                'analytics',
                'devops',
                'design',
                'testing',
                'documentation',
                'others',
            ]);

            $table->string('value')->index();
            $table->string('version')->nullable();

            $table->timestamps();

            // Un même (stack, catégorie, valeur) ne peut exister qu'une fois,
            // mais plusieurs technologies peuvent partager une même catégorie
            // au sein d'un même stack (ex: Laravel + Laravel Horizon en "backend").
            $table->unique(['stack_id', 'category', 'value']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stack_items');
        Schema::dropIfExists('stacks');
    }
};
