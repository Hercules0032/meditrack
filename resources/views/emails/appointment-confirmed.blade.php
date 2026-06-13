<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Appointment Confirmed</h2>
    <p>Dear {{ $appointment->patient->user->name }},</p>
    <p>Your appointment with Dr. {{ $appointment->doctor->user->name }} has been confirmed.</p>
    <p><strong>Date:</strong> {{ $appointment->appointment_date->format('M d, Y H:i') }}</p>
    <p>Thank you for choosing MediTrack.</p>
</body>
</html>
