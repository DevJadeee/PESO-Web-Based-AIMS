<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | PESO Agoo, La Union</title>
    
    <!-- PESO Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/peso-theme.css') }}">
    
    <!-- Lucide Icons (pinned stable version) -->
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.344.0/dist/umd/lucide.min.js"></script>

    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar no-print">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <img src="{{ asset('images/peso-logo.svg') }}" alt="PESO Logo">
                </div>
                <div class="sidebar-title">
                    <h1>PESO AGOO</h1>
                    <p>La Union LGU</p>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i data-lucide="layout-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.applicants.index') }}" class="sidebar-link {{ request()->routeIs('admin.applicants.*') ? 'active' : '' }}">
                        <i data-lucide="users"></i>
                        <span>Applicant Records</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.gip.index') }}" class="sidebar-link {{ request()->routeIs('admin.gip.*') ? 'active' : '' }}">
                        <i data-lucide="briefcase"></i>
                        <span>GIP Applications</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.job.index') }}" class="sidebar-link {{ request()->routeIs('admin.job.*') ? 'active' : '' }}">
                        <i data-lucide="building-2"></i>
                        <span>Job Applications</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.spes.index') }}" class="sidebar-link {{ request()->routeIs('admin.spes.*') ? 'active' : '' }}">
                        <i data-lucide="graduation-cap"></i>
                        <span>SPES Applications</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i data-lucide="file-text"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.qr.index') }}" class="sidebar-link {{ request()->routeIs('admin.qr.*') ? 'active' : '' }}">
                        <i data-lucide="qr-code"></i>
                        <span>Municipal QR Poster</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i data-lucide="settings"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Are you sure you want to log out?');">
                    @csrf
                    <button type="submit" class="sidebar-link" style="width: 100%; border: none; background: transparent; cursor: pointer; text-align: left;">
                        <i data-lucide="log-out"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="main-content">
            <!-- Top Header -->
            <header class="top-header no-print">
                <div class="header-title">
                    <h2>@yield('header_title', 'Dashboard')</h2>
                    <p>Municipal Public Employment Service Office - Agoo, La Union</p>
                </div>

                <div class="header-right">
                    <form action="{{ route('admin.applicants.index') }}" method="GET" class="search-bar">
                        <i data-lucide="search"></i>
                        <input type="text" name="search" placeholder="Search applicant code, name..." value="{{ request('search') }}">
                    </form>

                    <div class="user-profile">
                        <div class="avatar">
                            {{ strtoupper(substr(Auth::user()->name ?? 'Admin', 0, 2)) }}
                        </div>
                        <div class="user-info d-none-mobile">
                            <span style="font-size: 13px; font-weight: 700; color: var(--peso-blue-dark); display: block;">{{ Auth::user()->name ?? 'Administrator' }}</span>
                            <span style="font-size: 11px; color: var(--text-secondary);">PESO Officer</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Alerts Container -->
            @if(session('success'))
                <div style="margin: 20px 28px 0; padding: 14px 20px; background: var(--peso-green-light); color: var(--peso-green); border-radius: var(--radius-md); font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
                    <span>✓ {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 16px; cursor: pointer;">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div style="margin: 20px 28px 0; padding: 14px 20px; background: var(--peso-red-light); color: var(--peso-red-dark); border-radius: var(--radius-md); font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
                    <span>⚠️ {{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 16px; cursor: pointer;">✕</button>
                </div>
            @endif

            <!-- Main Page Body -->
            <main class="page-body">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>
</html>
