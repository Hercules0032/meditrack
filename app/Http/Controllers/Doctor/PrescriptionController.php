<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Mail\PrescriptionReady;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PrescriptionController extends Controller
{
    public function create(Appointment $appointment, Request $request)
    {
        $this->authorizeDoctor($appointment);

        $medicineInfo = null;
        $medicineName = $request->input('medicine');

        if ($medicineName) {
            $response = Http::get('https://api.fda.gov/drug/label.json', [
                'search' => "openfda.brand_name:{$medicineName}",
                'limit' => 1,
            ]);

            if ($response->successful()) {
                $medicineInfo = $response->json();
            }
        }

        return view('doctor.prescriptions.create', compact('appointment', 'medicineInfo', 'medicineName'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        $this->authorizeDoctor($appointment);

        $data = $request->validate([
            'medicines' => 'required|string',
            'instructions' => 'required|string',
        ]);

        $prescription = $appointment->prescription()->updateOrCreate(
            ['appointment_id' => $appointment->id],
            $data
        );

        Mail::to($appointment->patient->user->email)->send(new PrescriptionReady($prescription));

        return redirect()->route('doctor.appointments.show', $appointment)
            ->with('success', __('messages.prescription_saved'));
    }

    public function show(Appointment $appointment)
    {
        $this->authorizeDoctor($appointment);
        $appointment->load('prescription', 'patient.user');

        return view('doctor.prescriptions.show', compact('appointment'));
    }

    private function authorizeDoctor(Appointment $appointment): void
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }
    }
}
