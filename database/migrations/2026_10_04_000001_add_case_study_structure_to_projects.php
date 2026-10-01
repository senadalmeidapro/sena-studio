<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            $table->text('constraints')->nullable();
            $table->enum('outcome_type', ['delivered', 'ongoing', 'internal'])->nullable();
            $table->string('client_context', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            $table->dropColumn(['constraints', 'outcome_type', 'client_context']);
        });
    }
};
