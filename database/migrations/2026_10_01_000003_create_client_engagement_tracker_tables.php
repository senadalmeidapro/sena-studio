<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('phone', 40)->nullable();
            $table->string('country', 120)->nullable();
            $table->text('notes')->nullable();
            $table->string('source')->nullable();
            $table->timestamps();
        });

        Schema::create('engagements', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('client_id')->constrained()->restrictOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('scope');
            $table->string('pricing_model', 30)->default('fixed');
            $table->unsignedBigInteger('amount')->nullable();
            $table->char('currency', 3)->default('EUR');
            $table->string('status', 30)->default('proposal')->index();
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
            $table->timestamps();
        });

        Schema::create('deliverables', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('engagement_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->date('due_at')->nullable()->index();
            $table->date('done_at')->nullable();
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('engagement_id')->constrained()->cascadeOnDelete();
            $table->string('number')->unique();
            $table->unsignedBigInteger('amount');
            $table->char('currency', 3)->default('EUR');
            $table->date('issued_at')->nullable();
            $table->date('due_at')->nullable()->index();
            $table->date('paid_at')->nullable();
            $table->string('status', 30)->default('draft')->index();
            $table->timestamps();
        });

        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->foreignId('client_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('client_id');
        });

        Schema::dropIfExists('invoices');
        Schema::dropIfExists('deliverables');
        Schema::dropIfExists('engagements');
        Schema::dropIfExists('clients');
    }
};
