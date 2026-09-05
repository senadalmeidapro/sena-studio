<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => "Sèna Gédéon D'ALMEIDA",
            'email' => 'senadalmeidapro@gmail.com',
            'password' => Hash::make('Sena-Studio@2026'),
            'email_verified_at' => now(),
        ]);
    }
}
