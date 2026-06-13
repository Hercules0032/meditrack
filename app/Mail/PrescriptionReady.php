<?php

namespace App\Mail;

use App\Models\Prescription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PrescriptionReady extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Prescription $prescription) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Prescription Ready - MediTrack',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.prescription-ready',
        );
    }
}
