<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentConfirmed;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $doctor = auth()->user()->doctor;
        $status = $request->input('status');

        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->where('doctor_id', $doctor->id)
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderBy('appointment_date')
            ->paginate(15);

        return view('doctor.appointments.index', compact('appointments', 'status'));
    }

    public function show(Appointment $appointment)
    {
        $this->authorizeDoctor($appointment);

        $appointment->load(['patient.user', 'prescription']);

        return view('doctor.appointments.show', compact('appointment'));
    }

    public function confirm(Appointment $appointment)
    {
        $this->authorizeDoctor($appointment);

        $appointment->update(['status' => 'confirmed']);

        Mail::to($appointment->patient->user->email)->send(new AppointmentConfirmed($appointment));

        return redirect()->back()->with('success', __('messages.appointment_confirmed'));
    }

    private function authorizeDoctor(Appointment $appointment): void
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }
    }
}
