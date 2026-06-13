<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Rules\FutureDate;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $patient = auth()->user()->patient;

        $appointments = Appointment::with(['doctor.user', 'prescription'])
            ->where('patient_id', $patient->id)
            ->orderByDesc('appointment_date')
            ->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')->get();

        return view('patient.appointments.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => ['required', 'date', new FutureDate],
            'notes' => 'nullable|string',
        ]);

        auth()->user()->patient->appointments()->create([
            'doctor_id' => $data['doctor_id'],
            'appointment_date' => $data['appointment_date'],
            'notes' => $data['notes'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('patient.appointments.index')->with('success', __('messages.appointment_booked'));
    }

    public function show(Appointment $appointment)
    {
        $this->authorizePatient($appointment);
        $appointment->load(['doctor.user', 'prescription']);

        return view('patient.appointments.show', compact('appointment'));
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorizePatient($appointment);
        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('patient.appointments.index')->with('success', __('messages.appointment_cancelled'));
    }

    private function authorizePatient(Appointment $appointment): void
    {
        if ($appointment->patient_id !== auth()->user()->patient->id) {
            abort(403);
        }
    }
}
