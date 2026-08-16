<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\EmploymentProgram;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ProgramModuleController extends Controller
{
    /**
     * GIP Applications Module
     */
    public function gip(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $program = EmploymentProgram::where('code', 'GIP')->firstOrFail();

        $query = Application::with('applicant')
            ->where('program_id', $program->id)
            ->latest();

        if ($search) {
            $query->search($search);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($dateFrom) {
            $query->whereDate('submission_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('submission_date', '<=', $dateTo);
        }

        $applications = $query->paginate(10)->withQueryString();

        return view('gip.index', compact('applications', 'program', 'search', 'status', 'dateFrom', 'dateTo'));
    }

    /**
     * Job Applications Module
     */
    public function job(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $program = EmploymentProgram::where('code', 'JOB')->firstOrFail();

        $query = Application::with('applicant')
            ->where('program_id', $program->id)
            ->latest();

        if ($search) {
            $query->search($search);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($dateFrom) {
            $query->whereDate('submission_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('submission_date', '<=', $dateTo);
        }

        $applications = $query->paginate(10)->withQueryString();

        return view('job.index', compact('applications', 'program', 'search', 'status', 'dateFrom', 'dateTo'));
    }

    /**
     * SPES Applications Module
     */
    public function spes(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $program = EmploymentProgram::where('code', 'SPES')->firstOrFail();

        $query = Application::with('applicant')
            ->where('program_id', $program->id)
            ->latest();

        if ($search) {
            $query->search($search);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($dateFrom) {
            $query->whereDate('submission_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('submission_date', '<=', $dateTo);
        }

        $applications = $query->paginate(10)->withQueryString();

        return view('spes.index', compact('applications', 'program', 'search', 'status', 'dateFrom', 'dateTo'));
    }

    /**
     * Update Application Status
     */
    public function showApplication($id)
    {
        try {
            $application = Application::with(['applicant', 'program'])->findOrFail($id);

            return view('applications.show', compact('application'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Application record not found or has already been removed.');
        }
    }

    public function editApplication($id)
    {
        try {
            $application = Application::with(['applicant', 'program'])->findOrFail($id);

            return view('applications.edit', compact('application'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Application record not found or has already been removed.');
        }
    }

    public function updateApplication(Request $request, $id)
    {
        try {
            $application = Application::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Application record not found or has already been removed.');
        }

        $request->validate([
            'purpose_or_position' => ['required', 'string', 'max:255'],
            'place_or_agency' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'time_in' => ['nullable', 'string', 'max:50'],
            'submission_date' => ['nullable', 'date'],
            'remarks' => ['nullable', 'string'],
        ]);

        $oldStatus = $application->status;
        $application->update([
            'purpose_or_position' => $request->purpose_or_position,
            'place_or_agency' => $request->place_or_agency,
            'status' => $request->status,
            'time_in' => $request->time_in,
            'submission_date' => $request->submission_date ?? $application->submission_date,
            'remarks' => $request->remarks ?? $application->remarks,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'UPDATE_APPLICATION',
            'description' => "Updated application {$application->application_number} from '{$oldStatus}' to '{$request->status}'.",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.applications.show', $application->id)
            ->with('success', 'Application record updated successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $application = Application::with('applicant', 'program')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Application record not found or has already been removed.');
        }

        $request->validate([
            'status' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);

        $oldStatus = $application->status;
        $application->update([
            'status' => $request->status,
            'remarks' => $request->remarks ?? $application->remarks,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'UPDATE_APPLICATION_STATUS',
            'description' => "Updated application {$application->application_number} status from '{$oldStatus}' to '{$request->status}'.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Application status updated to '{$request->status}'.");
    }

    /**
     * Delete Application Record
     */
    public function destroyApplication(Request $request, $id)
    {
        try {
            $application = Application::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Application record not found or has already been removed.');
        }

        $number = $application->application_number;

        $application->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'DELETE_APPLICATION',
            'description' => "Deleted application record {$number}.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Application record {$number} deleted successfully.");
    }

    /**
     * Print Application Form View
     */
    public function printApplication($id)
    {
        try {
            $application = Application::with('applicant', 'program')->findOrFail($id);

            return view('print.application', compact('application'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Application record not found or has already been removed.');
        }
    }
}
