<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->string('project_type', 50)->nullable();
            $table->text('goal')->nullable();
            $table->string('timeline', 50)->nullable();
            $table->string('budget_range', 30)->nullable();
        });

        DB::table('contact_messages')->whereNotNull('budget')->update(['budget_range' => DB::raw('budget')]);

        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->dropColumn('budget');
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->string('result_metric', 255)->nullable();
            $table->foreignId('testimonial_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::create('site_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('availability', 20)->default('available');
            $table->string('booking_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');

        Schema::table('projects', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('testimonial_id');
            $table->dropColumn('result_metric');
        });

        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->string('budget', 30)->nullable();
        });

        DB::table('contact_messages')->whereNotNull('budget_range')->update(['budget' => DB::raw('budget_range')]);

        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->dropColumn(['project_type', 'goal', 'timeline', 'budget_range']);
        });
    }
};
