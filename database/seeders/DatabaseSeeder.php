<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (blank($email) || blank($password)) {
            $this->command?->warn('ADMIN_EMAIL and ADMIN_PASSWORD are required to seed the admin account.');
        } else {
            User::query()->updateOrCreate(
                ['email' => $email],
                [
                    'name' => env('ADMIN_NAME', "Sèna Gédéon D'ALMEIDA"),
                    'password' => Hash::make($password),
                    'email_verified_at' => now(),
                    'is_admin' => true,
                ],
            );
        }

        $this->call(PortfolioSeeder::class);
    }
}
