<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Application;
use App\Models\EmploymentProgram;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard
     */
    public function index()
    {
        $totalApplicants = Applicant::where('is_active', true)->count();

        $gipProgram = EmploymentProgram::where('code', 'GIP')->first();
        $gipCount = $gipProgram ? Application::where('program_id', $gipProgram->id)->count() : 0;

        $jobProgram = EmploymentProgram::where('code', 'JOB')->first();
        $jobCount = $jobProgram ? Application::where('program_id', $jobProgram->id)->count() : 0;

        $spesProgram = EmploymentProgram::where('code', 'SPES')->first();
        $spesCount = $spesProgram ? Application::where('program_id', $spesProgram->id)->count() : 0;

        $recentApplications = Application::with(['applicant', 'program'])
            ->latest()
            ->take(6)
            ->get();

        $recentActivity = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalApplicants',
            'gipCount',
            'jobCount',
            'spesCount',
            'recentApplications',
            'recentActivity'
        ));
    }
}
