@extends('layouts.app')

@section('title', 'GIP Applications')
@section('header_title', 'Government Internship Program (GIP)')

@section('content')
<!-- Program Header Banner -->
<div style="background: linear-gradient(135deg, var(--peso-blue-dark), var(--peso-blue)); color: #FFFFFF; padding: 24px; border-radius: var(--radius-lg); margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
    <div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <span class="badge badge-blue" style="font-size: 14px; padding: 6px 12px;">GIP MODULE</span>
            <h2 style="font-size: 22px; font-weight: 800; color: #FFFFFF;">Government Internship Program</h2>
        </div>
        <p style="font-size: 13px; color: #CBD5E1; margin-top: 6px;">
            Provides internship opportunities for young workers seeking experience in municipal government service.
        </p>
    </div>
    <div style="background: rgba(255,255,255,0.1); padding: 12px 20px; border-radius: var(--radius-md); text-align: center;">
        <span style="font-size: 11px; text-transform: uppercase; color: var(--peso-yellow); font-weight: 700;">Total Applications</span>
        <div style="font-size: 26px; font-weight: 800; color: #FFFFFF;">{{ $applications->total() }}</div>
    </div>
</div>

<!-- Table Panel -->
<div class="panel-card">
    <div class="panel-header">
        <div class="panel-title">
            <i data-lucide="briefcase" style="color: var(--peso-blue);"></i>
            <h3>GIP Application Log & Management</h3>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div style="padding: 16px 24px; background: #F8FAFC; border-bottom: 1px solid var(--border-color);">
        <form action="{{ route('admin.gip.index') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div style="flex-grow: 1; min-width: 200px;">
                <input type="text" name="search" class="form-control" placeholder="Search applicant, purpose, agency..." value="{{ request('search') }}">
            </div>

            <div style="width: 160px;">
                <select name="status" class="form-control" onchange="this.form.submit()">
                    <option value="">-- All Statuses --</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Under Review" {{ request('status') == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                    <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div style="display: flex; align-items: center; gap: 6px;">
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                <span style="font-size: 12px; color: var(--text-muted);">to</span>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>

            <button type="submit" class="btn btn-secondary">
                <i data-lucide="filter"></i> Filter
            </button>

            @if(request('search') || request('status') || request('date_from') || request('date_to'))
                <a href="{{ route('admin.gip.index') }}" class="btn btn-secondary" style="color: var(--peso-red);">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="peso-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Applicant Name</th>
                    <th>Place / Agency</th>
                    <th>Purpose / Position</th>
                    <th>Time In</th>
                    <th>Contact Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $app->submission_date ? $app->submission_date->format('M d, Y') : 'N/A' }}</div>
                            <div style="font-size: 11px; color: var(--text-muted);">{{ $app->application_number }}</div>
                        </td>
                        <td>
                            <a href="{{ route('admin.applicants.show', $app->applicant_id) }}" style="font-weight: 700; color: var(--peso-blue-dark);">
                                {{ $app->applicant->full_name ?? 'Unknown' }}
                            </a>
                            <div style="font-size: 11px; color: var(--text-secondary);">{{ $app->applicant->applicant_code ?? '' }}</div>
                        </td>
                        <td>{{ $app->place_or_agency ?? 'PESO Agoo' }}</td>
                        <td>{{ $app->purpose_or_position }}</td>
                        <td><span class="badge badge-gray">{{ $app->time_in ?? 'N/A' }}</span></td>
                        <td>{{ $app->applicant->contact_number ?? 'N/A' }}</td>
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
                            <div class="data-action-stack">
                                <form action="{{ route('admin.applications.update-status', $app->id) }}" method="POST" class="status-action-form">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-control" onchange="this.form.submit()">
                                        <option value="Pending" {{ $app->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Under Review" {{ $app->status == 'Under Review' ? 'selected' : '' }}>Review</option>
                                        <option value="Approved" {{ $app->status == 'Approved' ? 'selected' : '' }}>Approve</option>
                                        <option value="Completed" {{ $app->status == 'Completed' ? 'selected' : '' }}>Complete</option>
                                        <option value="Rejected" {{ $app->status == 'Rejected' ? 'selected' : '' }}>Reject</option>
                                    </select>
                                </form>

                                <div class="action-button-group">
                                    <a href="{{ route('admin.applications.show', $app->id) }}"
                                       class="btn btn-sm"
                                       style="background: #EEF4FB; color: #0D3B66; border: 1px solid #c7dbef;"
                                       title="View Application">
                                        <i data-lucide="eye" style="width:14px;height:14px;"></i> View
                                    </a>

                                    <a href="{{ route('admin.applications.edit', $app->id) }}"
                                       class="btn btn-sm"
                                       style="background: #FEF3C7; color: #92400E; border: 1px solid #fcd34d;"
                                       title="Edit Application">
                                        <i data-lucide="edit-3" style="width:14px;height:14px;"></i> Edit
                                    </a>

                                    <a href="{{ route('admin.applications.print', $app->id) }}" target="_blank"
                                       class="btn btn-sm"
                                       style="background: #F1F5F9; color: #475569; border: 1px solid #CBD5E1;"
                                       title="Print Application Form">
                                        <i data-lucide="printer" style="width:14px;height:14px;"></i> Print
                                    </a>

                                    <form action="{{ route('admin.applications.destroy', $app->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this GIP application record? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"
                                                style="background: #FEE2E2; color: #B91C1C; border: 1px solid #fca5a5;"
                                                title="Delete Application">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 30px;">
                            No GIP applications recorded.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 16px 24px; border-top: 1px solid var(--border-color);">
        {{ $applications->links() }}
    </div>
</div>
@endsection
