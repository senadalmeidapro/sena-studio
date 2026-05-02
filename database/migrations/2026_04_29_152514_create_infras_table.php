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
        Schema::create('infras', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->text('description')->nullable();

            // AJOUT: Configuration Docker/Kubernetes
            $table->string('docker_image')->nullable();
            $table->string('kubernetes_config')->nullable();
            $table->string('helm_chart')->nullable();

            // AJOUT: Ressources allouées
            $table->integer('cpu_cores')->default(1);
            $table->integer('memory_mb')->default(512);
            $table->integer('storage_gb')->default(10);

            // AJOUT: Environnement
            $table->enum('environment', [
                'development', 'staging', 'production',
            ])->default('development');

            // AJOUT: État
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infras');
    }
};
