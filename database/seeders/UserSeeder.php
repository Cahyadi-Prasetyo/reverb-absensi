<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Guru Matematika',
            'email' => 'teacher@example.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);

        \App\Models\User::create([
            'name' => 'Siswa A',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);
    }
}
