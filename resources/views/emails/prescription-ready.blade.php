<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Prescription Ready</h2>
    <p>Dear {{ $prescription->appointment->patient->user->name }},</p>
    <p>Your prescription from Dr. {{ $prescription->appointment->doctor->user->name }} is ready.</p>
    <p><strong>Medicines:</strong> {{ $prescription->medicines }}</p>
    <p><strong>Instructions:</strong> {{ $prescription->instructions }}</p>
</body>
</html>
