<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('route_name')->nullable()->index();
            $table->string('locale', 2)->nullable()->index();
            $table->string('referer', 512)->nullable();
            $table->string('user_agent', 512)->nullable();
            $table->string('ip_hash', 64)->nullable()->index();
            $table->boolean('is_bot')->default(false)->index();
            $table->timestamp('created_at')->nullable()->index();

            $table->index(['created_at', 'is_bot']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
