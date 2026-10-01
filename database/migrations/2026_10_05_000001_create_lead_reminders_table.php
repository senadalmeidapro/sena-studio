<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_reminders', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('contact_message_id')->constrained()->cascadeOnDelete();
            $table->date('reminded_on');
            $table->timestamps();
            $table->unique(['contact_message_id', 'reminded_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_reminders');
    }
};
