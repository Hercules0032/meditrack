<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        User::where('role', 'patient')->each(function (User $user) {
            Patient::create([
                'user_id' => $user->id,
                'dob' => fake()->dateTimeBetween('-70 years', '-18 years'),
                'gender' => fake()->randomElement(['male', 'female', 'other']),
                'phone' => fake()->numerify('##########'),
                'address' => fake()->address(),
                'blood_group' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            ]);
        });
    }
}
