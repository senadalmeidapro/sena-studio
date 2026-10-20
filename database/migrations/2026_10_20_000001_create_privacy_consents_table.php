<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('privacy_consents', function (Blueprint $table): void {
            $table->uuid('consent_id')->primary();
            $table->string('provider', 120);
            $table->string('choice', 10);
            $table->string('policy_version', 16);
            $table->timestamp('created_at')->useCurrent();
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('privacy_consents');
    }
};
