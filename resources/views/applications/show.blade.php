@extends('layouts.app')

@section('title', 'Application Details')
@section('header_title', 'Application Record - ' . $application->application_number)

@section('content')
<div style="display: flex; gap: 16px; margin-bottom: 20px; flex-wrap: wrap;">
    <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('admin.dashboard') }}" class="btn btn-secondary">
        <i data-lucide="arrow-left"></i> Back
    </a>
    <a href="{{ route('admin.applications.edit', $application->id) }}" class="btn btn-secondary">
        <i data-lucide="pencil"></i> Edit Application
    </a>
    <a href="{{ route('admin.applications.print', $application->id) }}" target="_blank" class="btn btn-primary">
        <i data-lucide="printer"></i> Print Form
    </a>
</div>

<div class="panel-card" style="padding: 24px;">
    <div class="panel-header">
        <div class="panel-title">
            <i data-lucide="file-text" style="color: var(--peso-blue);"></i>
            <h3>{{ $application->application_number }}</h3>
        </div>
        <span class="badge badge-gray">{{ $application->program->code }}</span>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, minmax(220px, 1fr)); gap: 18px; margin-top: 16px;">
        <div>
            <strong style="display: block; color: var(--text-secondary); font-size: 12px; margin-bottom: 6px;">Applicant</strong>
            <div style="font-weight: 700; color: var(--peso-blue-dark);">{{ $application->applicant->full_name ?? 'Unknown' }}</div>
            <div style="font-size: 12px; color: var(--text-secondary);">{{ $application->applicant->applicant_code ?? 'N/A' }}</div>
        </div>
        <div>
            <strong style="display: block; color: var(--text-secondary); font-size: 12px; margin-bottom: 6px;">Program</strong>
            <div>{{ $application->program->name }}</div>
        </div>
        <div>
            <strong style="display: block; color: var(--text-secondary); font-size: 12px; margin-bottom: 6px;">Purpose / Position</strong>
            <div>{{ $application->purpose_or_position ?? 'N/A' }}</div>
        </div>
        <div>
            <strong style="display: block; color: var(--text-secondary); font-size: 12px; margin-bottom: 6px;">Place / Agency</strong>
            <div>{{ $application->place_or_agency ?? 'N/A' }}</div>
        </div>
        <div>
            <strong style="display: block; color: var(--text-secondary); font-size: 12px; margin-bottom: 6px;">Time In</strong>
            <div>{{ $application->time_in ?? 'N/A' }}</div>
        </div>
        <div>
            <strong style="display: block; color: var(--text-secondary); font-size: 12px; margin-bottom: 6px;">Status</strong>
            @if($application->status == 'Approved')
                <span class="badge badge-green">Approved</span>
            @elseif($application->status == 'Pending')
                <span class="badge badge-yellow">Pending</span>
            @elseif($application->status == 'Under Review')
                <span class="badge badge-blue">Under Review</span>
            @elseif($application->status == 'Rejected')
                <span class="badge badge-red">Rejected</span>
            @else
                <span class="badge badge-gray">{{ $application->status }}</span>
            @endif
        </div>
        <div>
            <strong style="display: block; color: var(--text-secondary); font-size: 12px; margin-bottom: 6px;">Submission Date</strong>
            <div>{{ $application->submission_date ? $application->submission_date->format('F d, Y') : 'N/A' }}</div>
        </div>
        <div>
            <strong style="display: block; color: var(--text-secondary); font-size: 12px; margin-bottom: 6px;">Remarks</strong>
            <div>{{ $application->remarks ?? 'None' }}</div>
        </div>
    </div>
</div>
@endsection
