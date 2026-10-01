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
        $email = config('admin.email');
        $password = config('admin.password');

        if (blank($email) || blank($password)) {
            if (config('app.env') === 'production') {
                throw new \RuntimeException('ADMIN_EMAIL and ADMIN_PASSWORD must be set before running the production seeder.');
            }

            $this->command?->warn('ADMIN_EMAIL and ADMIN_PASSWORD are required to seed the admin account.');
        } else {
            $user = User::query()->updateOrCreate(
                ['email' => $email],
                [
                    'name' => config('admin.name') ?: "Sèna Gédéon D'ALMEIDA",
                    'password' => Hash::make($password),
                    'email_verified_at' => now(),
                ],
            );
            $user->forceFill(['is_admin' => true])->save();
        }

        $this->call(PortfolioSeeder::class);
    }
}
