<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $doctors = Doctor::with('user')
            ->when($search, fn ($q) => $q->whereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%")))
            ->paginate(10);

        return view('admin.doctors.index', compact('doctors', 'search'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'specialization' => 'required|string',
            'license_number' => 'required|unique:doctors',
            'phone' => 'required|digits_between:10,15',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        $doctor = $user->doctor()->create([
            'specialization' => $data['specialization'],
            'license_number' => $data['license_number'],
            'phone' => $data['phone'],
        ]);

        $slug = Str::of($doctor->user->name)->lower()->slug('-')->toString();

        return redirect()->route('admin.doctors.index')
            ->with('success', __('messages.doctor_created') . " (slug: {$slug})");
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'appointments.patient.user']);

        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $doctor->load('user');

        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'specialization' => 'required|string',
            'license_number' => 'required|unique:doctors,license_number,' . $doctor->id,
            'phone' => 'required|digits_between:10,15',
        ]);

        $doctor->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $doctor->update([
            'specialization' => $data['specialization'],
            'license_number' => $data['license_number'],
            'phone' => $data['phone'],
        ]);

        return redirect()->route('admin.doctors.index')->with('success', __('messages.doctor_updated'));
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete();

        return redirect()->route('admin.doctors.index')->with('success', __('messages.doctor_deleted'));
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'exists:doctors,id']);

        $doctors = Doctor::whereIn('id', $request->ids)->with('user')->get();
        foreach ($doctors as $doctor) {
            $doctor->user->delete();
        }

        return redirect()->route('admin.doctors.index')->with('success', __('messages.doctors_deleted'));
    }
}
