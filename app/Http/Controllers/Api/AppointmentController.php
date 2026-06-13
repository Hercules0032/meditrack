<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Rules\FutureDate;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderBy('appointment_date')
            ->paginate(15);

        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => ['required', 'date', new FutureDate],
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create([
            ...$data,
            'status' => 'pending',
        ]);

        return response()->json($appointment->load(['patient.user', 'doctor.user']), 201);
    }

    public function show(Appointment $appointment)
    {
        return response()->json($appointment->load(['patient.user', 'doctor.user', 'prescription']));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'patient_id' => 'sometimes|exists:patients,id',
            'doctor_id' => 'sometimes|exists:doctors,id',
            'appointment_date' => ['sometimes', 'date', new FutureDate],
            'status' => 'sometimes|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($data);

        return response()->json($appointment->load(['patient.user', 'doctor.user']));
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(null, 204);
    }
}
