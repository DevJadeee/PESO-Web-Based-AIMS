@extends('layouts.app')

@section('title', 'Edit Applicant Record')
@section('header_title', 'Edit Record - ' . $applicant->full_name)

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.applicants.show', $applicant->id) }}" class="btn btn-secondary">
        <i data-lucide="arrow-left"></i> Back to Profile
    </a>
</div>

<div class="panel-card" style="max-width: 900px; margin: 0 auto;">
    <div class="panel-header">
        <div class="panel-title">
            <i data-lucide="edit-3" style="color: var(--peso-blue);"></i>
            <h3>Update Applicant Information</h3>
        </div>
        <span style="font-size: 12px; font-weight: 700; color: var(--peso-blue);">{{ $applicant->applicant_code }}</span>
    </div>

    <form action="{{ route('admin.applicants.update', $applicant->id) }}" method="POST" style="padding: 28px;">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
            <div class="form-group">
                <label for="first_name" class="form-label">First Name *</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name', $applicant->first_name) }}" required>
            </div>

            <div class="form-group">
                <label for="middle_name" class="form-label">Middle Name</label>
                <input type="text" id="middle_name" name="middle_name" class="form-control" value="{{ old('middle_name', $applicant->middle_name) }}">
            </div>

            <div class="form-group">
                <label for="last_name" class="form-label">Last Name *</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name', $applicant->last_name) }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
            <div class="form-group">
                <label for="suffix" class="form-label">Suffix</label>
                <input type="text" id="suffix" name="suffix" class="form-control" value="{{ old('suffix', $applicant->suffix) }}" placeholder="e.g. Jr, III">
            </div>

            <div class="form-group">
                <label for="birth_date" class="form-label">Birth Date</label>
                <input type="date" id="birth_date" name="birth_date" class="form-control" value="{{ old('birth_date', $applicant->birth_date ? $applicant->birth_date->format('Y-m-d') : '') }}">
            </div>

            <div class="form-group">
                <label for="gender" class="form-label">Gender</label>
                <select id="gender" name="gender" class="form-control">
                    <option value="Male" {{ old('gender', $applicant->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $applicant->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="civil_status" class="form-label">Civil Status</label>
                <select id="civil_status" name="civil_status" class="form-control">
                    <option value="Single" {{ old('civil_status', $applicant->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                    <option value="Married" {{ old('civil_status', $applicant->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                    <option value="Widowed" {{ old('civil_status', $applicant->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                    <option value="Separated" {{ old('civil_status', $applicant->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label for="contact_number" class="form-label">Contact Number *</label>
                <input type="text" id="contact_number" name="contact_number" class="form-control" value="{{ old('contact_number', $applicant->contact_number) }}" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $applicant->email) }}">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px;">
            <div class="form-group">
                <label for="barangay" class="form-label">Barangay (Agoo)</label>
                <input type="text" id="barangay" name="barangay" class="form-control" value="{{ old('barangay', $applicant->barangay) }}">
            </div>

            <div class="form-group">
                <label for="address" class="form-label">Full Address</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $applicant->address) }}">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label for="educational_attainment" class="form-label">Educational Attainment</label>
                <select id="educational_attainment" name="educational_attainment" class="form-control">
                    <option value="High School" {{ old('educational_attainment', $applicant->educational_attainment) == 'High School' ? 'selected' : '' }}>High School</option>
                    <option value="College Undergraduate" {{ old('educational_attainment', $applicant->educational_attainment) == 'College Undergraduate' ? 'selected' : '' }}>College Undergraduate</option>
                    <option value="College Graduate" {{ old('educational_attainment', $applicant->educational_attainment) == 'College Graduate' ? 'selected' : '' }}>College Graduate</option>
                    <option value="Vocational" {{ old('educational_attainment', $applicant->educational_attainment) == 'Vocational' ? 'selected' : '' }}>Vocational</option>
                    <option value="Masteral/Doctorate" {{ old('educational_attainment', $applicant->educational_attainment) == 'Masteral/Doctorate' ? 'selected' : '' }}>Masteral/Doctorate</option>
                </select>
            </div>

            <div class="form-group">
                <label for="course_or_major" class="form-label">Course / Major</label>
                <input type="text" id="course_or_major" name="course_or_major" class="form-control" value="{{ old('course_or_major', $applicant->course_or_major) }}">
            </div>
        </div>

        <div class="form-group">
            <label for="skills" class="form-label">Skills & Qualifications</label>
            <textarea id="skills" name="skills" class="form-control" rows="3">{{ old('skills', $applicant->skills) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label for="emergency_contact_name" class="form-label">Emergency Contact Name</label>
                <input type="text" id="emergency_contact_name" name="emergency_contact_name" class="form-control" value="{{ old('emergency_contact_name', $applicant->emergency_contact_name) }}">
            </div>

            <div class="form-group">
                <label for="emergency_contact_number" class="form-label">Emergency Contact Number</label>
                <input type="text" id="emergency_contact_number" name="emergency_contact_number" class="form-control" value="{{ old('emergency_contact_number', $applicant->emergency_contact_number) }}">
            </div>
        </div>

        <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
            <a href="{{ route('admin.applicants.show', $applicant->id) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i data-lucide="check"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
