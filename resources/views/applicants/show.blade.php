@extends('layouts.app')

@section('title', 'Applicant Profile Details')
@section('header_title', 'Applicant Profile - ' . $applicant->full_name)

@section('content')
<div style="display: flex; gap: 16px; margin-bottom: 20px;">
    <a href="{{ route('admin.applicants.index') }}" class="btn btn-secondary">
        <i data-lucide="arrow-left"></i> Back to Directory
    </a>
    <a href="{{ route('admin.applicants.edit', $applicant->id) }}" class="btn btn-secondary">
        <i data-lucide="edit"></i> Edit Profile
    </a>
    <a href="{{ route('admin.applicants.print', $applicant->id) }}" target="_blank" class="btn btn-primary">
        <i data-lucide="printer"></i> Print Official Profile
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- Profile Summary Box -->
    <div class="panel-card" style="padding: 24px; text-align: center;">
        <div class="avatar" style="width: 80px; height: 80px; font-size: 28px; margin: 0 auto 16px;">
            {{ strtoupper(substr($applicant->first_name, 0, 1) . substr($applicant->last_name, 0, 1)) }}
        </div>
        <h2 style="font-size: 20px; font-weight: 800; color: var(--peso-blue-dark);">{{ $applicant->full_name }}</h2>
        <p style="font-size: 13px; color: var(--peso-blue); font-weight: 700; margin-top: 4px;">{{ $applicant->applicant_code }}</p>
        
        <div style="margin-top: 20px; text-align: left; font-size: 13px; border-top: 1px solid var(--border-color); padding-top: 16px; display: flex; flex-direction: column; gap: 10px;">
            <div>
                <strong style="color: var(--text-secondary);">Contact Number:</strong>
                <div>{{ $applicant->contact_number }}</div>
            </div>
            <div>
                <strong style="color: var(--text-secondary);">Email Address:</strong>
                <div>{{ $applicant->email ?? 'N/A' }}</div>
            </div>
            <div>
                <strong style="color: var(--text-secondary);">Barangay:</strong>
                <div>{{ $applicant->barangay ?? 'Agoo' }}</div>
            </div>
            <div>
                <strong style="color: var(--text-secondary);">Complete Address:</strong>
                <div>{{ $applicant->address ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Right Side Details & Applications -->
    <div>
        <!-- Personal & Educational Information -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <i data-lucide="user" style="color: var(--peso-blue);"></i>
                    <h3>Personal & Educational Profile</h3>
                </div>
            </div>
            <div style="padding: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 16px; font-size: 14px;">
                <div>
                    <strong style="color: var(--text-secondary); font-size: 12px; display: block;">BIRTH DATE</strong>
                    <div>{{ $applicant->birth_date ? $applicant->birth_date->format('F d, Y') : 'N/A' }}</div>
                </div>
                <div>
                    <strong style="color: var(--text-secondary); font-size: 12px; display: block;">GENDER</strong>
                    <div>{{ $applicant->gender ?? 'N/A' }}</div>
                </div>
                <div>
                    <strong style="color: var(--text-secondary); font-size: 12px; display: block;">CIVIL STATUS</strong>
                    <div>{{ $applicant->civil_status ?? 'N/A' }}</div>
                </div>
                <div>
                    <strong style="color: var(--text-secondary); font-size: 12px; display: block;">EDUCATIONAL ATTAINMENT</strong>
                    <div>{{ $applicant->educational_attainment ?? 'N/A' }}</div>
                </div>
                <div style="grid-column: span 2;">
                    <strong style="color: var(--text-secondary); font-size: 12px; display: block;">COURSE / MAJOR</strong>
                    <div>{{ $applicant->course_or_major ?? 'N/A' }}</div>
                </div>
                <div style="grid-column: span 2;">
                    <strong style="color: var(--text-secondary); font-size: 12px; display: block;">SKILLS & QUALIFICATIONS</strong>
                    <div>{{ $applicant->skills ?? 'None specified' }}</div>
                </div>
                <div>
                    <strong style="color: var(--text-secondary); font-size: 12px; display: block;">EMERGENCY CONTACT PERSON</strong>
                    <div>{{ $applicant->emergency_contact_name ?? 'N/A' }}</div>
                </div>
                <div>
                    <strong style="color: var(--text-secondary); font-size: 12px; display: block;">EMERGENCY PHONE NUMBER</strong>
                    <div>{{ $applicant->emergency_contact_number ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Program Applications History -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <i data-lucide="file-check" style="color: var(--peso-blue);"></i>
                    <h3>Employment Program Applications</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="peso-table">
                    <thead>
                        <tr>
                            <th>Application No.</th>
                            <th>Program</th>
                            <th>Purpose / Position</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applicant->applications as $app)
                            <tr>
                                <td style="font-weight: 700; color: var(--peso-blue-dark);">{{ $app->application_number }}</td>
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
                                <td>{{ $app->submission_date ? $app->submission_date->format('M d, Y') : 'N/A' }}</td>
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
                                    <a href="{{ route('admin.applications.print', $app->id) }}" target="_blank" class="btn btn-secondary btn-sm">
                                        <i data-lucide="printer"></i> Form
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 20px;">
                                    No program applications submitted yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
