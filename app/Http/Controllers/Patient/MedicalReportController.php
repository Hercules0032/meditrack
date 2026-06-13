<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\MedicalReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicalReportController extends Controller
{
    public function index()
    {
        $reports = auth()->user()->patient->medicalReports()
            ->orderByDesc('uploaded_at')
            ->paginate(10);

        return view('patient.reports.index', compact('reports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'report' => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $file = $request->file('report');
        $path = $file->store('medical_reports', 'public');

        auth()->user()->patient->medicalReports()->create([
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'uploaded_at' => now(),
        ]);

        return redirect()->route('patient.reports.index')->with('success', __('messages.report_uploaded'));
    }

    public function destroy(MedicalReport $report)
    {
        if ($report->patient_id !== auth()->user()->patient->id) {
            abort(403);
        }

        Storage::disk('public')->delete($report->file_path);
        $report->delete();

        return redirect()->route('patient.reports.index')->with('success', __('messages.report_deleted'));
    }
}
