<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Online Application') | PESO Agoo, La Union</title>
    
    <!-- PESO Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/peso-theme.css') }}">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('styles')
</head>
<body class="public-body">
    <div class="public-container">
        <div class="public-card">
            <div class="public-header">
                <div class="public-header-logo">
                    <img src="{{ asset('images/peso-logo.svg') }}" alt="PESO Logo">
                </div>
                <div class="public-header-text">
                    <h1>MUNICIPALITY OF AGOO, LA UNION</h1>
                    <p>Public Employment Service Office (PESO)</p>
                </div>
            </div>

            <div style="padding: 30px;">
                @yield('content')
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 20px; font-size: 12px; color: var(--text-secondary);">
            &copy; {{ date('Y') }} Public Employment Service Office - Agoo, La Union. All rights reserved.
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
