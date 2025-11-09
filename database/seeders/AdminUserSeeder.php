<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'employee_id' => 'ADM001',
                'role' => 'admin',
                'department' => 'IT',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created: admin@example.com / password');
    }
}
