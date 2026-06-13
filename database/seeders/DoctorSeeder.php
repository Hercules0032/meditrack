<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $specializations = ['Cardiology', 'Neurology', 'Pediatrics', 'Orthopedics', 'Dermatology'];

        User::where('role', 'doctor')->each(function (User $user, int $index) use ($specializations) {
            Doctor::create([
                'user_id' => $user->id,
                'specialization' => $specializations[$index % count($specializations)],
                'license_number' => 'LIC-' . str_pad((string) ($index + 1), 5, '0', STR_PAD_LEFT),
                'phone' => fake()->numerify('##########'),
            ]);
        });
    }
}
