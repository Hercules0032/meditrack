<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@meditrack.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::factory()->count(5)->create(['role' => 'doctor']);
        User::factory()->count(50)->create(['role' => 'patient']);
    }
}
