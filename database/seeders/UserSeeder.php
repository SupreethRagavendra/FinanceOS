<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the users table with default admin, analyst, and viewer accounts.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@finance.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Analyst User',
            'email' => 'analyst@finance.com',
            'password' => Hash::make('password'),
            'role' => 'analyst',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Viewer User',
            'email' => 'viewer@finance.com',
            'password' => Hash::make('password'),
            'role' => 'viewer',
            'status' => 'active',
        ]);
    }
}
