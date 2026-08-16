@extends('layouts.app')

@section('title', 'System Settings')
@section('header_title', 'Administrative & Office Settings')

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <div>
        <!-- Office & System Information Card -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <i data-lucide="building" style="color: var(--peso-blue);"></i>
                    <h3>Municipal Office Configuration</h3>
                </div>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" style="padding: 24px;">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label class="form-label">LGU Municipality</label>
                        <input type="text" class="form-control" value="Municipality of Agoo" readonly style="background: #F1F5F9;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Province</label>
                        <input type="text" class="form-control" value="La Union" readonly style="background: #F1F5F9;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Office Name</label>
                    <input type="text" class="form-control" value="Public Employment Service Office (PESO)" readonly style="background: #F1F5F9;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label class="form-label">Official Contact Phone</label>
                        <input type="text" class="form-control" value="(072) 682-1234 / 0917-888-AGOO" readonly style="background: #F1F5F9;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Official Email</label>
                        <input type="text" class="form-control" value="peso@agoolaunion.gov.ph" readonly style="background: #F1F5F9;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Office Address</label>
                    <input type="text" class="form-control" value="Ground Floor, Municipal Hall, Agoo, 2504 La Union" readonly style="background: #F1F5F9;">
                </div>

                <div style="text-align: right;">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="check"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Active Employment Assistance Programs -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <i data-lucide="layers" style="color: var(--peso-blue);"></i>
                    <h3>Configured Employment Assistance Programs</h3>
                </div>
            </div>

            <div class="table-responsive">
                <table class="peso-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Program Name</th>
                            <th>Badge Color</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as $p)
                            <tr>
                                <td style="font-weight: 700; color: var(--peso-blue-dark);">{{ $p->code }}</td>
                                <td>
                                    <div style="font-weight: 600;">{{ $p->name }}</div>
                                    <div style="font-size: 11px; color: var(--text-secondary);">{{ Str::limit($p->description, 60) }}</div>
                                </td>
                                <td>
                                    @if($p->badge_color == 'blue')
                                        <span class="badge badge-blue">Blue Theme</span>
                                    @elseif($p->badge_color == 'red')
                                        <span class="badge badge-red">Red Theme</span>
                                    @else
                                        <span class="badge badge-green">Green Theme</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-green">Active</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Side System Info & Admins -->
    <div>
        <!-- System Specifications Panel -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <i data-lucide="server" style="color: var(--peso-blue);"></i>
                    <h3>System Environment</h3>
                </div>
            </div>
            <div style="padding: 20px; font-size: 13px; display: flex; flex-direction: column; gap: 12px;">
                <div>
                    <strong style="color: var(--text-secondary); font-size: 11px; display: block;">SYSTEM TITLE</strong>
                    <div style="font-weight: 600; color: var(--peso-blue-dark);">PESO Applicant Information System</div>
                </div>
                <div>
                    <strong style="color: var(--text-secondary); font-size: 11px; display: block;">BACKEND FRAMEWORK</strong>
                    <div>Laravel 12 (PHP {{ PHP_VERSION }})</div>
                </div>
                <div>
                    <strong style="color: var(--text-secondary); font-size: 11px; display: block;">DATABASE ENGINE</strong>
                    <div>Supabase / PostgreSQL (Relational Engine)</div>
                </div>
                <div>
                    <strong style="color: var(--text-secondary); font-size: 11px; display: block;">APPLICANT ACCESS MODE</strong>
                    <div>Public QR-Code Scanner (Account-Free)</div>
                </div>
                <div>
                    <strong style="color: var(--text-secondary); font-size: 11px; display: block;">THESIS METHODOLOGY</strong>
                    <div>Rapid Application Development (RAD)</div>
                </div>
            </div>
        </div>

        <!-- Administrator Accounts Panel -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <i data-lucide="shield-check" style="color: var(--peso-blue);"></i>
                    <h3>Admin User Accounts</h3>
                </div>
            </div>
            <div style="padding: 16px; display: flex; flex-direction: column; gap: 14px;">
                @foreach($adminUsers as $u)
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px; border: 1px solid var(--border-color); border-radius: var(--radius-md); background: #F8FAFC;">
                        <div style="display: flex; align-items: center; gap: 12px; min-width: 0; flex: 1;">
                            <div class="avatar" style="width: 34px; height: 34px; font-size: 12px; flex-shrink: 0;">
                                {{ strtoupper(substr($u->name, 0, 2)) }}
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 13px; font-weight: 700; color: var(--peso-blue-dark);">{{ $u->name }}</div>
                                <div style="font-size: 11px; color: var(--text-secondary);">{{ $u->username ?? 'No username' }} &bull; {{ $u->email }}</div>
                                <div style="font-size: 11px; color: var(--text-secondary);">Role: {{ ucfirst(str_replace('_', ' ', $u->role ?? 'staff')) }} &bull; {{ $u->contact_number ?? 'No contact number' }}</div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 6px; flex-wrap: wrap; justify-content: flex-end;">
                            <button type="button" class="btn btn-sm" style="background: #EEF4FB; color: #0D3B66; border: 1px solid #c7dbef;" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $u->id }}">
                                <i data-lucide="pencil" style="width:14px;height:14px;"></i> Edit
                            </button>
                            <button type="button" class="btn btn-sm" style="background: #F1F5F9; color: #475569; border: 1px solid #CBD5E1;" data-bs-toggle="modal" data-bs-target="#changePasswordModal{{ $u->id }}">
                                <i data-lucide="key-round" style="width:14px;height:14px;"></i> Password
                            </button>
                            @if(auth()->id() !== $u->id)
                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user account?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background: #FEE2E2; color: #B91C1C; border: 1px solid #fca5a5;">
                                        <i data-lucide="trash-2" style="width:14px;height:14px;"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="modal fade" id="editUserModal{{ $u->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $u->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--border-color);">
                                <form action="{{ route('admin.users.update', $u->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header" style="padding: 18px 20px; border-bottom: 1px solid var(--border-color);">
                                        <h5 class="modal-title" id="editUserModalLabel{{ $u->id }}" style="font-weight: 700; color: var(--peso-blue-dark);">Edit User Account</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="padding: 20px; display: grid; gap: 14px;">
                                        <div class="form-group">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $u->name) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control" value="{{ old('username', $u->username) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Gmail / Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email', $u->email) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Role</label>
                                            <select name="role" class="form-control" required>
                                                <option value="super_admin" {{ old('role', $u->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                                <option value="manager" {{ old('role', $u->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                                                <option value="staff" {{ old('role', $u->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Contact Number</label>
                                            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $u->contact_number) }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="padding: 18px 20px; border-top: 1px solid var(--border-color);">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="changePasswordModal{{ $u->id }}" tabindex="-1" aria-labelledby="changePasswordModalLabel{{ $u->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--border-color);">
                                <form action="{{ route('admin.users.update-password', $u->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header" style="padding: 18px 20px; border-bottom: 1px solid var(--border-color);">
                                        <h5 class="modal-title" id="changePasswordModalLabel{{ $u->id }}" style="font-weight: 700; color: var(--peso-blue-dark);">Change Password</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="padding: 20px;">
                                        <div class="form-group">
                                            <label class="form-label">New Password</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="padding: 18px 20px; border-top: 1px solid var(--border-color);">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i data-lucide="user-plus"></i> Add User
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--border-color);">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="padding: 18px 20px; border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title" id="addUserModalLabel" style="font-weight: 700; color: var(--peso-blue-dark);">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 20px; display: grid; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Gmail / Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-control" required>
                            <option value="super_admin">Super Admin</option>
                            <option value="manager">Manager</option>
                            <option value="staff" selected>Staff</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control">
                    </div>
                </div>
                <div class="modal-footer" style="padding: 18px 20px; border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
