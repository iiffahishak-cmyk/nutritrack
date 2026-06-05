<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Change the email and password to whatever you want to use to log in
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@nutritrack.com',
            'password' => Hash::make('password123'),
            // If you have a role or is_admin column, add it here! e.g., 'role' => 'admin'
        ]);
    }
}