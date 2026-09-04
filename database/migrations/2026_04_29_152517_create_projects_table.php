<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->string('version')->default('1.0.0');
            $table->decimal('price', 10, 2)->default(0.00);

            $table->string('url')->nullable();
            $table->string('repository_url')->nullable();
            $table->string('image')->nullable();

            $table->enum('status', ['development', 'testing', 'production', 'cancelled'])
                ->default('development');
            $table->enum('type', ['web', 'app', 'software'])
                ->default('web');
            $table->enum('complexity', ['simple', 'medium', 'complex'])
                ->default('simple');
            $table->enum('visibility', ['public', 'private', 'protected'])
                ->default('public');

            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();

            $table->foreignId('stack_id')
                ->nullable()
                ->constrained('stacks')
                ->onDelete('set null');

            $table->foreignId('infra_id')
                ->nullable()
                ->constrained('infras')
                ->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
