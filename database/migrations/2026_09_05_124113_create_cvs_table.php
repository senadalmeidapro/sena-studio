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
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Curriculum Vitae');
            $table->string('version_label')->nullable();
            $table->string('slug')->unique();
            $table->string('template')->default('classique')->index();
            $table->string('status')->default('draft')->index();
            $table->string('accent_color', 32)->nullable();
            $table->boolean('is_primary')->default(false);

            $table->string('headline')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->text('summary')->nullable();

            $table->json('links')->nullable();
            $table->json('experience')->nullable();
            $table->json('education')->nullable();
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();
            $table->json('certifications')->nullable();
            $table->json('hobbies')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};
