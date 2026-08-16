<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\EmploymentProgram;
use App\Models\Application;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ApplicantManagementController extends Controller
{
    /**
     * Display Central Applicant Records
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $programCode = $request->input('program');
        $education = $request->input('education');

        $query = Applicant::with(['applications.program'])->latest();

        if ($search) {
            $query->search($search);
        }

        if ($programCode) {
            $query->whereHas('applications.program', function ($q) use ($programCode) {
                $q->where('code', strtoupper($programCode));
            });
        }

        if ($education) {
            $query->where('educational_attainment', $education);
        }

        $applicants = $query->paginate(10)->withQueryString();
        $programs = EmploymentProgram::all();

        return view('applicants.index', compact('applicants', 'search', 'programCode', 'education', 'programs'));
    }

    /**
     * View Applicant Full Details
     */
    public function show($id)
    {
        $applicant = Applicant::with(['applications.program'])->findOrFail($id);
        $programs = EmploymentProgram::where('is_active', true)->get();

        return view('applicants.show', compact('applicant', 'programs'));
    }

    /**
     * Show Edit Form
     */
    public function edit($id)
    {
        $applicant = Applicant::findOrFail($id);
        return view('applicants.edit', compact('applicant'));
    }

    /**
     * Update Applicant Record
     */
    public function update(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string'],
            'civil_status' => ['nullable', 'string'],
            'contact_number' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'barangay' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'educational_attainment' => ['nullable', 'string'],
            'course_or_major' => ['nullable', 'string'],
            'skills' => ['nullable', 'string'],
            'emergency_contact_name' => ['nullable', 'string'],
            'emergency_contact_number' => ['nullable', 'string'],
        ]);

        $applicant->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'UPDATE_APPLICANT',
            'description' => 'Updated details for applicant ' . $applicant->applicant_code . ' (' . $applicant->full_name . ').',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.applicants.show', $applicant->id)
            ->with('success', 'Applicant record updated successfully.');
    }

    /**
     * Delete Applicant Record
     */
    public function destroy(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);
        $code = $applicant->applicant_code;
        $name = $applicant->full_name;

        $applicant->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'DELETE_APPLICANT',
            'description' => "Deleted applicant record {$code} ({$name}).",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.applicants.index')
            ->with('success', "Applicant record {$code} deleted successfully.");
    }

    /**
     * Printable Record View
     */
    public function print($id)
    {
        $applicant = Applicant::with(['applications.program'])->findOrFail($id);
        return view('print.applicant', compact('applicant'));
    }
}
