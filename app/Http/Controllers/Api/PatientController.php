<?php

namespace App\Http\Controllers\Api;

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

        return response()->json($patients);
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

        $patient = $user->patient()->create([
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'phone' => $data['phone'],
            'address' => $data['address'] ?? null,
            'blood_group' => $data['blood_group'] ?? null,
        ]);

        return response()->json($patient->load('user'), 201);
    }

    public function show(Patient $patient)
    {
        return response()->json($patient->load('user'));
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'name' => 'sometimes|min:3',
            'email' => 'sometimes|email|unique:users,email,' . $patient->user_id,
            'dob' => ['sometimes', 'date', 'before:today', new FutureAdultAge],
            'phone' => 'sometimes|digits_between:10,15',
            'gender' => 'sometimes|in:male,female,other',
            'address' => 'nullable|string',
            'blood_group' => 'nullable|string',
        ]);

        if (isset($data['name']) || isset($data['email'])) {
            $patient->user->update(array_filter([
                'name' => $data['name'] ?? null,
                'email' => $data['email'] ?? null,
            ]));
        }

        $patient->update(array_filter([
            'dob' => $data['dob'] ?? null,
            'gender' => $data['gender'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'blood_group' => $data['blood_group'] ?? null,
        ]));

        return response()->json($patient->load('user'));
    }

    public function destroy(Patient $patient)
    {
        $patient->user->delete();

        return response()->json(null, 204);
    }
}
