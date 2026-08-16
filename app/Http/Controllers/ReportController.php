<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\EmploymentProgram;
use App\Models\Applicant;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display Reports Suite
     */
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth()->toDateString());
        $programId = $request->input('program_id');
        $status = $request->input('status');

        $query = Application::with(['applicant', 'program']);

        if ($dateFrom) {
            $query->whereDate('submission_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('submission_date', '<=', $dateTo);
        }

        if ($programId) {
            $query->where('program_id', $programId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $applications = $query->latest()->get();

        // Statistics breakdown
        $totalReportCount = $applications->count();
        $gipReportCount = $applications->where('program.code', 'GIP')->count();
        $jobReportCount = $applications->where('program.code', 'JOB')->count();
        $spesReportCount = $applications->where('program.code', 'SPES')->count();

        $approvedCount = $applications->where('status', 'Approved')->count();
        $pendingCount = $applications->where('status', 'Pending')->count();
        $underReviewCount = $applications->where('status', 'Under Review')->count();

        $programs = EmploymentProgram::all();

        return view('reports.index', compact(
            'applications',
            'programs',
            'dateFrom',
            'dateTo',
            'programId',
            'status',
            'totalReportCount',
            'gipReportCount',
            'jobReportCount',
            'spesReportCount',
            'approvedCount',
            'pendingCount',
            'underReviewCount'
        ));
    }

    /**
     * Printable Summary Report
     */
    public function printReport(Request $request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth()->toDateString());
        $programId = $request->input('program_id');
        $status = $request->input('status');

        $query = Application::with(['applicant', 'program']);

        if ($dateFrom) {
            $query->whereDate('submission_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('submission_date', '<=', $dateTo);
        }

        if ($programId) {
            $query->where('program_id', $programId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $applications = $query->latest()->get();

        $selectedProgram = $programId ? EmploymentProgram::find($programId) : null;

        return view('print.report', compact('applications', 'dateFrom', 'dateTo', 'selectedProgram', 'status'));
    }
}
