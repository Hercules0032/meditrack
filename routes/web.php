<?php

use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Doctor\PrescriptionController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\ContactController;
use App\Http\Controllers\Patient\MedicalReportController;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route(auth()->user()->role . '.dashboard')
        : view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'bn'])) {
        session(['locale' => $locale]);
    }

    return back();
})->name('lang.switch');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'totalPatients' => Patient::count(),
            'totalDoctors' => Doctor::count(),
            'totalAppointments' => Appointment::count(),
            'pendingAppointments' => Appointment::where('status', 'pending')->count(),
        ]);
    })->name('dashboard');

    Route::resource('patients', PatientController::class);
    Route::post('patients/bulk-delete', [PatientController::class, 'bulkDestroy'])->name('patients.bulk-delete');

    Route::resource('doctors', DoctorController::class);
    Route::post('doctors/bulk-delete', [DoctorController::class, 'bulkDestroy'])->name('doctors.bulk-delete');

    Route::resource('appointments', AdminAppointmentController::class);
    Route::match(['put', 'patch'], 'appointments/{id}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.status');
    Route::post('appointments/bulk-delete', [AdminAppointmentController::class, 'bulkDestroy'])->name('appointments.bulk-delete');
});

Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'doctor'])->group(function () {
    Route::get('/dashboard', function () {
        $doctorId = auth()->user()->doctor->id;

        return view('doctor.dashboard', [
            'todayAppointments' => Appointment::where('doctor_id', $doctorId)->whereDate('appointment_date', today())->count(),
            'pendingAppointments' => Appointment::where('doctor_id', $doctorId)->where('status', 'pending')->count(),
            'totalPatients' => Appointment::where('doctor_id', $doctorId)->distinct('patient_id')->count('patient_id'),
        ]);
    })->name('dashboard');

    Route::controller(DoctorAppointmentController::class)->group(function () {
        Route::get('/appointments', 'index')->name('appointments.index');
        Route::get('/appointments/{appointment}', 'show')->name('appointments.show');
        Route::post('/appointments/{appointment}/confirm', 'confirm')->name('appointments.confirm');
    });

    Route::get('/appointments/{appointment}/prescription/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
    Route::post('/appointments/{appointment}/prescription', [PrescriptionController::class, 'store'])->name('prescriptions.store');
    Route::get('/appointments/{appointment}/prescription', [PrescriptionController::class, 'show'])->name('prescriptions.show');
});

Route::prefix('patient')->name('patient.')->middleware(['auth', 'patient'])->group(function () {
    Route::get('/dashboard', function () {
        $patientId = auth()->user()->patient->id;

        return view('patient.dashboard', [
            'upcomingAppointments' => Appointment::where('patient_id', $patientId)->where('appointment_date', '>=', now())->count(),
            'totalReports' => auth()->user()->patient->medicalReports()->count(),
            'prescriptions' => Prescription::whereHas('appointment', fn ($q) => $q->where('patient_id', $patientId))->count(),
        ]);
    })->name('dashboard');

    Route::resource('appointments', PatientAppointmentController::class)->except(['edit', 'update']);
    Route::get('/reports', [MedicalReportController::class, 'index'])->name('reports.index');
    Route::post('/reports', [MedicalReportController::class, 'store'])->name('reports.store');
    Route::delete('/reports/{report}', [MedicalReportController::class, 'destroy'])->name('reports.destroy');

    Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});
