<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE notifications ALTER COLUMN data TYPE json USING data::json');
        } elseif (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE notifications MODIFY data JSON NOT NULL');
        } else {
            Schema::table('notifications', function (Blueprint $table) {
                $table->json('data')->nullable()->change();
            });
        }
    }

    public function down(): void {}
};
