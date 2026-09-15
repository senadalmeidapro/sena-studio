<?php

namespace Database\Seeders;

use App\Models\ModelHasRole;
use App\Models\Role;
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
            $admin = User::query()->updateOrCreate(
                ['email' => $email],
                [
                    'name' => env('ADMIN_NAME'),
                    'password' => Hash::make($password),
                    'email_verified_at' => now(),
                ],
            );

            $role = Role::query()->firstOrCreate([
                'name' => 'admin',
                'guard_name' => 'web',
            ]);

            ModelHasRole::query()->firstOrCreate([
                'role_id' => $role->getKey(),
                'model_type' => User::class,
                'model_id' => $admin->getKey(),
            ]);
        }

        $this->call(PortfolioSeeder::class);
    }
}
