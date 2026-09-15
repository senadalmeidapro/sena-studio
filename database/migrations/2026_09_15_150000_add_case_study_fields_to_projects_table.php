<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            $table->string('role')->nullable()->after('description');
            $table->text('problem')->nullable()->after('role');
            $table->text('architecture')->nullable()->after('problem');
            $table->text('technical_decisions')->nullable()->after('architecture');
            $table->text('result')->nullable()->after('technical_decisions');
            $table->boolean('featured')->default(false)->after('result');
            $table->unsignedInteger('sort_order')->default(0)->after('featured');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            $table->dropColumn(['role', 'problem', 'architecture', 'technical_decisions', 'result', 'featured', 'sort_order']);
        });
    }
};
