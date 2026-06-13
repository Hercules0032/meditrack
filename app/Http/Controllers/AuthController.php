<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            session([
                'user_id' => $user->id,
                'role' => $user->role,
            ]);

            session()->flash('success', __('messages.logged_in'));

            return redirect()->route($user->role . '.dashboard');
        }

        return back()->withErrors(['email' => __('messages.invalid_credentials')])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:patient,doctor',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        if ($data['role'] === 'patient') {
            $user->patient()->create([
                'dob' => now()->subYears(25),
                'gender' => 'other',
                'phone' => '0000000000',
                'address' => '',
            ]);
        } else {
            $user->doctor()->create([
                'specialization' => 'General',
                'license_number' => 'LIC-' . str_pad((string) $user->id, 5, '0', STR_PAD_LEFT),
                'phone' => '0000000000',
            ]);
        }

        Auth::login($user);
        session(['user_id' => $user->id, 'role' => $user->role]);
        session()->flash('success', __('messages.registered'));

        return redirect()->route($user->role . '.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->flash('success', __('messages.logged_out'));

        return redirect()->route('login');
    }
}
