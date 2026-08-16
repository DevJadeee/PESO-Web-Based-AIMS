@extends('layouts.app')

@section('title', 'Applicant Records')
@section('header_title', 'Central Applicant Directory')

@section('content')
<div class="panel-card">
    <div class="panel-header">
        <div class="panel-title">
            <i data-lucide="users" style="color: var(--peso-blue);"></i>
            <h3>Master Applicant Information Records</h3>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('public.register') }}" target="_blank" class="btn btn-primary btn-sm">
                <i data-lucide="plus"></i> New Application (Public Form)
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div style="padding: 16px 24px; background: #F8FAFC; border-bottom: 1px solid var(--border-color);">
        <form action="{{ route('admin.applicants.index') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div style="flex-grow: 1; min-width: 220px;">
                <input type="text" name="search" class="form-control" placeholder="Search applicant code, name, contact, barangay..." value="{{ request('search') }}">
            </div>

            <div style="width: 180px;">
                <select name="program" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Filter by Program --</option>
                    @foreach($programs as $p)
                        <option value="{{ $p->code }}" {{ request('program') == $p->code ? 'selected' : '' }}>
                            {{ $p->code }} - {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="width: 200px;">
                <select name="education" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Filter by Education --</option>
                    <option value="High School" {{ request('education') == 'High School' ? 'selected' : '' }}>High School</option>
                    <option value="College Undergraduate" {{ request('education') == 'College Undergraduate' ? 'selected' : '' }}>College Undergraduate</option>
                    <option value="College Graduate" {{ request('education') == 'College Graduate' ? 'selected' : '' }}>College Graduate</option>
                    <option value="Vocational" {{ request('education') == 'Vocational' ? 'selected' : '' }}>Vocational</option>
                </select>
            </div>

            <button type="submit" class="btn btn-secondary">
                <i data-lucide="filter"></i> Filter
            </button>

            @if(request('search') || request('program') || request('education'))
                <a href="{{ route('admin.applicants.index') }}" class="btn btn-secondary" style="color: var(--peso-red);">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="peso-table">
            <thead>
                <tr>
                    <th>Applicant Code</th>
                    <th>Full Name</th>
                    <th>Contact & Email</th>
                    <th>Barangay</th>
                    <th>Educational Attainment</th>
                    <th>Registered Programs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applicants as $applicant)
                    <tr>
                        <td style="font-weight: 700; color: var(--peso-blue-dark);">
                            {{ $applicant->applicant_code }}
                        </td>
                        <td>
                            <div style="font-weight: 600;">{{ $applicant->full_name }}</div>
                            <div style="font-size: 11px; color: var(--text-secondary);">
                                {{ $applicant->gender ?? 'N/A' }} &bull; {{ $applicant->civil_status ?? 'N/A' }}
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 13px;">{{ $applicant->contact_number }}</div>
                            <div style="font-size: 11px; color: var(--text-muted);">{{ $applicant->email ?? 'No email provided' }}</div>
                        </td>
                        <td>{{ $applicant->barangay ?? 'Agoo' }}</td>
                        <td>
                            <span class="badge badge-gray">{{ $applicant->educational_attainment ?? 'Unspecified' }}</span>
                            @if($applicant->course_or_major)
                                <div style="font-size: 11px; color: var(--text-secondary); margin-top: 2px;">{{ $applicant->course_or_major }}</div>
                            @endif
                        </td>
                        <td>
                            @forelse($applicant->applications as $app)
                                @if($app->program->code == 'GIP')
                                    <span class="badge badge-blue">GIP</span>
                                @elseif($app->program->code == 'JOB')
                                    <span class="badge badge-red">JOB</span>
                                @else
                                    <span class="badge badge-green">SPES</span>
                                @endif
                            @empty
                                <span style="font-size: 11px; color: var(--text-muted);">None</span>
                            @endforelse
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                <a href="{{ route('admin.applicants.show', $applicant->id) }}"
                                   class="btn btn-sm"
                                   style="background: #EEF4FB; color: #0D3B66; border: 1px solid #c7dbef; gap: 5px;"
                                   title="View Full Profile">
                                    <i data-lucide="eye" style="width:14px;height:14px;"></i> View
                                </a>
                                <a href="{{ route('admin.applicants.edit', $applicant->id) }}"
                                   class="btn btn-sm"
                                   style="background: #FEF3C7; color: #92400E; border: 1px solid #fcd34d; gap: 5px;"
                                   title="Edit Applicant Details">
                                    <i data-lucide="edit-3" style="width:14px;height:14px;"></i> Edit
                                </a>
                                <a href="{{ route('admin.applicants.print', $applicant->id) }}" target="_blank"
                                   class="btn btn-sm"
                                   style="background: #F1F5F9; color: #475569; border: 1px solid #CBD5E1; gap: 5px;"
                                   title="Print Applicant Record">
                                    <i data-lucide="printer" style="width:14px;height:14px;"></i> Print
                                </a>
                                <form action="{{ route('admin.applicants.destroy', $applicant->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to permanently delete this applicant record?');"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm"
                                            style="background: #FEE2E2; color: #B91C1C; border: 1px solid #fca5a5; gap: 5px;"
                                            title="Delete Applicant">
                                        <i data-lucide="trash-2" style="width:14px;height:14px;"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: var(--text-muted);">
                            No applicant records found matching search criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div style="padding: 16px 24px; border-top: 1px solid var(--border-color);">
        {{ $applicants->links() }}
    </div>
</div>
@endsection
