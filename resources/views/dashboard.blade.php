@extends('layouts.app')

@section('title', 'Administrative Dashboard')
@section('header_title', 'Operational Overview')

@section('content')
<!-- Metrics Summary Grid -->
<div class="metrics-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h3>Total Applicants</h3>
            <div class="value">{{ number_format($totalApplicants) }}</div>
            <p style="font-size: 12px; color: var(--text-secondary);">Central Database Profiles</p>
        </div>
        <div class="stat-icon">
            <i data-lucide="users" style="width: 28px; height: 28px;"></i>
        </div>
    </div>

    <div class="stat-card stat-gip">
        <div class="stat-info">
            <h3>GIP Applications</h3>
            <div class="value">{{ number_format($gipCount) }}</div>
            <p style="font-size: 12px; color: var(--peso-blue); font-weight: 600;">Govt Internship Program</p>
        </div>
        <div class="stat-icon">
            <i data-lucide="briefcase" style="width: 28px; height: 28px;"></i>
        </div>
    </div>

    <div class="stat-card stat-job">
        <div class="stat-info">
            <h3>Job Applications</h3>
            <div class="value">{{ number_format($jobCount) }}</div>
            <p style="font-size: 12px; color: var(--peso-red); font-weight: 600;">Job Referral & Placement</p>
        </div>
        <div class="stat-icon">
            <i data-lucide="building-2" style="width: 28px; height: 28px;"></i>
        </div>
    </div>

    <div class="stat-card stat-spes">
        <div class="stat-info">
            <h3>SPES Applications</h3>
            <div class="value">{{ number_format($spesCount) }}</div>
            <p style="font-size: 12px; color: var(--peso-green); font-weight: 600;">Student Employment</p>
        </div>
        <div class="stat-icon">
            <i data-lucide="graduation-cap" style="width: 28px; height: 28px;"></i>
        </div>
    </div>
</div>

<!-- Main Dashboard Grid -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Left Column: Recent Applications -->
    <div class="panel-card">
        <div class="panel-header">
            <div class="panel-title">
                <i data-lucide="clock" style="color: var(--peso-blue);"></i>
                <h3>Recent Application Submissions</h3>
            </div>
            <a href="{{ route('admin.applicants.index') }}" class="btn btn-secondary btn-sm">View All Records</a>
        </div>

        <div class="table-responsive">
            <table class="peso-table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Applicant Name</th>
                        <th>Program</th>
                        <th>Purpose / Position</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentApplications as $app)
                        <tr>
                            <td>
                                <div style="font-weight: 600;">{{ $app->submission_date ? $app->submission_date->format('M d, Y') : 'N/A' }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $app->time_in ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <a href="{{ route('admin.applicants.show', $app->applicant_id) }}" style="font-weight: 600; color: var(--peso-blue-dark);">
                                    {{ $app->applicant->full_name ?? 'Unknown' }}
                                </a>
                                <div style="font-size: 11px; color: var(--text-secondary);">{{ $app->applicant->applicant_code ?? '' }}</div>
                            </td>
                            <td>
                                @if($app->program->code == 'GIP')
                                    <span class="badge badge-blue">GIP</span>
                                @elseif($app->program->code == 'JOB')
                                    <span class="badge badge-red">JOB</span>
                                @else
                                    <span class="badge badge-green">SPES</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($app->purpose_or_position, 24) }}</td>
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
                            <td>
                                <a href="{{ route('admin.applications.print', $app->id) }}" target="_blank" class="btn btn-secondary btn-sm" title="Print Application Form">
                                    <i data-lucide="printer"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                No applications recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right Column: Quick Actions & Activity Log -->
    <div>
        <!-- Quick Actions Panel -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <i data-lucide="zap" style="color: var(--peso-yellow-dark);"></i>
                    <h3>Quick Operations</h3>
                </div>
            </div>
            <div style="padding: 18px; display: flex; flex-direction: column; gap: 10px;">
                <a href="{{ route('public.register') }}" target="_blank" class="btn btn-secondary" style="justify-content: flex-start;">
                    <i data-lucide="external-link"></i> Open Public Applicant Form
                </a>
                <a href="{{ route('admin.qr.index') }}" class="btn btn-primary" style="justify-content: flex-start;">
                    <i data-lucide="qr-code"></i> View/Print Municipal QR Code
                </a>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary" style="justify-content: flex-start;">
                    <i data-lucide="file-text"></i> Generate Official PESO Report
                </a>
            </div>
        </div>

        <!-- Recent Audit Trail -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <i data-lucide="activity" style="color: var(--peso-blue);"></i>
                    <h3>System Activity Log</h3>
                </div>
            </div>
            <div style="padding: 16px;">
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 12px;">
                    @forelse($recentActivity as $log)
                        <li style="border-bottom: 1px dashed var(--border-color); padding-bottom: 8px;">
                            <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">
                                {{ $log->action }}
                            </div>
                            <div style="font-size: 12px; color: var(--text-secondary);">
                                {{ Str::limit($log->description, 50) }}
                            </div>
                            <div style="font-size: 10px; color: var(--text-muted); margin-top: 2px;">
                                {{ $log->created_at->diffForHumans() }}
                            </div>
                        </li>
                    @empty
                        <li style="font-size: 12px; color: var(--text-muted);">No activity logged yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
