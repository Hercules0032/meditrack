<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('patient.contact.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            Mail::raw(
                "From: " . auth()->user()->name . " (" . auth()->user()->email . ")\n\n" . $data['message'],
                function ($mail) use ($admin, $data) {
                    $mail->to($admin->email)
                        ->subject('[MediTrack Contact] ' . $data['subject']);
                }
            );
        }

        return redirect()->route('patient.dashboard')->with('success', __('messages.message_sent'));
    }
}
