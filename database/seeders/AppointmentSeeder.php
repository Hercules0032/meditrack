<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        foreach ($patients->random(min(30, $patients->count())) as $patient) {
            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => fake()->dateTimeBetween('now', '+30 days'),
                'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
                'notes' => fake()->optional()->sentence(),
            ]);
        }
    }
}
