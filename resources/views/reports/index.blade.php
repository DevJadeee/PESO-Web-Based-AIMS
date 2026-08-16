@extends('layouts.app')

@section('title', 'Reports & Analytics')
@section('header_title', 'Report Generation & Analytics Suite')

@section('content')
<!-- Filter Control Card -->
<div class="panel-card" style="margin-bottom: 24px;">
    <div class="panel-header">
        <div class="panel-title">
            <i data-lucide="sliders" style="color: var(--peso-blue);"></i>
            <h3>Report Filter Options</h3>
        </div>
        <div>
            <a href="{{ route('admin.reports.print', request()->all()) }}" target="_blank" class="btn btn-primary">
                <i data-lucide="printer"></i> Print Official Report
            </a>
        </div>
    </div>

    <form action="{{ route('admin.reports.index') }}" method="GET" style="padding: 20px;">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="date_from" class="form-label">Date From</label>
                <input type="date" id="date_from" name="date_from" class="form-control" value="{{ $dateFrom }}">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="date_to" class="form-label">Date To</label>
                <input type="date" id="date_to" name="date_to" class="form-control" value="{{ $dateTo }}">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="program_id" class="form-label">Program Module</label>
                <select id="program_id" name="program_id" class="form-control">
                    <option value="">-- All Programs --</option>
                    @foreach($programs as $p)
                        <option value="{{ $p->id }}" {{ $programId == $p->id ? 'selected' : '' }}>
                            {{ $p->code }} - {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="status" class="form-label">Application Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="">-- All Statuses --</option>
                    <option value="Approved" {{ $status == 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Under Review" {{ $status == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                    <option value="Completed" {{ $status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Rejected" {{ $status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 16px;">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Reset Filters</a>
            <button type="submit" class="btn btn-primary">
                <i data-lucide="search"></i> Generate Report
            </button>
        </div>
    </form>
</div>

<!-- Aggregated Report Metrics -->
<div class="metrics-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h3>Filtered Total</h3>
            <div class="value">{{ number_format($totalReportCount) }}</div>
            <p style="font-size: 12px; color: var(--text-secondary);">Applications Recorded</p>
        </div>
        <div class="stat-icon"><i data-lucide="file-text"></i></div>
    </div>

    <div class="stat-card stat-gip">
        <div class="stat-info">
            <h3>GIP Applications</h3>
            <div class="value">{{ number_format($gipReportCount) }}</div>
            <p style="font-size: 12px; color: var(--peso-blue);">Govt Internship</p>
        </div>
        <div class="stat-icon"><i data-lucide="briefcase"></i></div>
    </div>

    <div class="stat-card stat-job">
        <div class="stat-info">
            <h3>Job Placement</h3>
            <div class="value">{{ number_format($jobReportCount) }}</div>
            <p style="font-size: 12px; color: var(--peso-red);">Job Referrals</p>
        </div>
        <div class="stat-icon"><i data-lucide="building-2"></i></div>
    </div>

    <div class="stat-card stat-spes">
        <div class="stat-info">
            <h3>SPES Students</h3>
            <div class="value">{{ number_format($spesReportCount) }}</div>
            <p style="font-size: 12px; color: var(--peso-green);">Student Employment</p>
        </div>
        <div class="stat-icon"><i data-lucide="graduation-cap"></i></div>
    </div>
</div>

<!-- Generated Report Table -->
<div class="panel-card">
    <div class="panel-header">
        <div class="panel-title">
            <i data-lucide="table" style="color: var(--peso-blue);"></i>
            <h3>Report Details Summary Data</h3>
        </div>
        <span style="font-size: 12px; color: var(--text-secondary);">
            Period: {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
        </span>
    </div>

    <div class="table-responsive">
        <table class="peso-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>App Number</th>
                    <th>Submission Date</th>
                    <th>Applicant Name</th>
                    <th>Barangay</th>
                    <th>Program</th>
                    <th>Purpose / Position</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $index => $app)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style="font-weight: 700; color: var(--peso-blue-dark);">{{ $app->application_number }}</td>
                        <td>{{ $app->submission_date ? $app->submission_date->format('M d, Y') : 'N/A' }}</td>
                        <td style="font-weight: 600;">{{ $app->applicant->full_name ?? 'N/A' }}</td>
                        <td>{{ $app->applicant->barangay ?? 'Agoo' }}</td>
                        <td>
                            @if($app->program->code == 'GIP')
                                <span class="badge badge-blue">GIP</span>
                            @elseif($app->program->code == 'JOB')
                                <span class="badge badge-red">JOB</span>
                            @else
                                <span class="badge badge-green">SPES</span>
                            @endif
                        </td>
                        <td>{{ $app->purpose_or_position }}</td>
                        <td>
                            @if($app->status == 'Approved')
                                <span class="badge badge-green">Approved</span>
                            @elseif($app->status == 'Pending')
                                <span class="badge badge-yellow">Pending</span>
                            @elseif($app->status == 'Under Review')
                                <span class="badge badge-blue">Under Review</span>
                            @else
                                <span class="badge badge-gray">{{ $app->status }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 30px;">
                            No applications match the selected report criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
