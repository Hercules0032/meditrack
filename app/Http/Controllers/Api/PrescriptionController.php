<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with('appointment.patient.user', 'appointment.doctor.user')
            ->paginate(15);

        return response()->json($prescriptions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:prescriptions,appointment_id',
            'medicines' => 'required|string',
            'instructions' => 'required|string',
        ]);

        $prescription = Prescription::create($data);

        return response()->json($prescription->load('appointment'), 201);
    }

    public function show(Prescription $prescription)
    {
        return response()->json($prescription->load('appointment.patient.user', 'appointment.doctor.user'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        $data = $request->validate([
            'medicines' => 'sometimes|string',
            'instructions' => 'sometimes|string',
        ]);

        $prescription->update($data);

        return response()->json($prescription->load('appointment'));
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return response()->json(null, 204);
    }
}
