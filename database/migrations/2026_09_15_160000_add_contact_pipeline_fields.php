<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->string('status')->default('new')->index()->after('message');
            $table->string('priority')->default('normal')->index()->after('status');
            $table->dateTime('follow_up_at')->nullable()->index()->after('priority');
            $table->text('internal_notes')->nullable()->after('follow_up_at');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->dropColumn(['status', 'priority', 'follow_up_at', 'internal_notes']);
        });
    }
};
