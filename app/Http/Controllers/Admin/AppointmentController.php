<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
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

        return view('admin.appointments.index', compact('appointments', 'status'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();

        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => ['required', 'date', new FutureDate],
            'notes' => 'nullable|string',
        ]);

        Appointment::create([
            'patient_id' => $data['patient_id'],
            'doctor_id' => $data['doctor_id'],
            'appointment_date' => $data['appointment_date'],
            'notes' => $data['notes'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.appointments.index')->with('success', __('messages.appointment_created'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor.user', 'prescription']);

        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();

        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => ['required', 'date', new FutureDate],
            'status' => 'required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($data);

        return redirect()->route('admin.appointments.index')->with('success', __('messages.appointment_updated'));
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', __('messages.appointment_deleted'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => $data['status']]);

        return redirect()->back()->with('success', __('messages.appointment_status_updated'));
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'exists:appointments,id']);

        Appointment::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.appointments.index')->with('success', __('messages.appointments_deleted'));
    }
}
