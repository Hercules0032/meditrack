<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use App\Rules\FutureAdultAge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $patients = Patient::with('user')
            ->when($search, fn ($q) => $q->whereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%")))
            ->paginate(10);

        return view('admin.patients.index', compact('patients', 'search'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'dob' => ['required', 'date', 'before:today', new FutureAdultAge],
            'phone' => 'required|digits_between:10,15',
            'gender' => 'required|in:male,female,other',
            'address' => 'nullable|string',
            'blood_group' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);

        $user->patient()->create([
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'phone' => $data['phone'],
            'address' => $data['address'] ?? null,
            'blood_group' => $data['blood_group'] ?? null,
        ]);

        return redirect()->route('admin.patients.index')->with('success', __('messages.patient_created'));
    }

    public function show(Patient $patient)
    {
        $patient->load(['user', 'appointments.doctor.user', 'medicalReports']);

        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $patient->load('user');

        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $patient->user_id,
            'dob' => ['required', 'date', 'before:today', new FutureAdultAge],
            'phone' => 'required|digits_between:10,15',
            'gender' => 'required|in:male,female,other',
            'address' => 'nullable|string',
            'blood_group' => 'nullable|string',
        ]);

        $patient->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $patient->update([
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'phone' => $data['phone'],
            'address' => $data['address'] ?? null,
            'blood_group' => $data['blood_group'] ?? null,
        ]);

        return redirect()->route('admin.patients.index')->with('success', __('messages.patient_updated'));
    }

    public function destroy(Patient $patient)
    {
        $patient->user->delete();

        return redirect()->route('admin.patients.index')->with('success', __('messages.patient_deleted'));
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'exists:patients,id']);

        $patients = Patient::whereIn('id', $request->ids)->with('user')->get();
        foreach ($patients as $patient) {
            $patient->user->delete();
        }

        return redirect()->route('admin.patients.index')->with('success', __('messages.patients_deleted'));
    }
}
