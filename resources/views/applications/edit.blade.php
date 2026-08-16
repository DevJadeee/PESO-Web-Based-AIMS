@extends('layouts.app')

@section('title', 'Edit Application')
@section('header_title', 'Edit Application - ' . $application->application_number)

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.applications.show', $application->id) }}" class="btn btn-secondary">
        <i data-lucide="arrow-left"></i> Back to Application
    </a>
</div>

<div class="panel-card" style="max-width: 900px; margin: 0 auto;">
    <div class="panel-header">
        <div class="panel-title">
            <i data-lucide="edit-3" style="color: var(--peso-blue);"></i>
            <h3>Update Application Details</h3>
        </div>
        <span style="font-size: 12px; font-weight: 700; color: var(--peso-blue);">{{ $application->application_number }}</span>
    </div>

    <form action="{{ route('admin.applications.update', $application->id) }}" method="POST" style="padding: 28px;">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(2, minmax(220px, 1fr)); gap: 16px;">
            <div class="form-group">
                <label for="program_name" class="form-label">Program</label>
                <input type="text" id="program_name" class="form-control" value="{{ $application->program->name }} ({{ $application->program->code }})" disabled>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">Status *</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="Pending" {{ old('status', $application->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Under Review" {{ old('status', $application->status) == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                    <option value="Approved" {{ old('status', $application->status) == 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Completed" {{ old('status', $application->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Rejected" {{ old('status', $application->status) == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="form-group">
                <label for="purpose_or_position" class="form-label">Purpose / Position *</label>
                <input type="text" id="purpose_or_position" name="purpose_or_position" class="form-control" value="{{ old('purpose_or_position', $application->purpose_or_position) }}" required>
            </div>

            <div class="form-group">
                <label for="place_or_agency" class="form-label">Place / Agency</label>
                <input type="text" id="place_or_agency" name="place_or_agency" class="form-control" value="{{ old('place_or_agency', $application->place_or_agency) }}">
            </div>

            <div class="form-group">
                <label for="time_in" class="form-label">Time In</label>
                <input type="text" id="time_in" name="time_in" class="form-control" value="{{ old('time_in', $application->time_in) }}" placeholder="e.g. 08:15 AM">
            </div>

            <div class="form-group">
                <label for="submission_date" class="form-label">Submission Date</label>
                <input type="date" id="submission_date" name="submission_date" class="form-control" value="{{ old('submission_date', $application->submission_date ? $application->submission_date->format('Y-m-d') : '') }}">
            </div>
        </div>

        <div class="form-group" style="margin-top: 16px;">
            <label for="remarks" class="form-label">Remarks</label>
            <textarea id="remarks" name="remarks" class="form-control" rows="4">{{ old('remarks', $application->remarks) }}</textarea>
        </div>

        <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
            <a href="{{ route('admin.applications.show', $application->id) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i data-lucide="check"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
