@extends('layouts.app')

@section('title', 'Municipal QR Code Poster')
@section('header_title', 'Municipal Applicant QR Code Generator')

@section('content')
<div style="display: flex; gap: 16px; margin-bottom: 20px;" class="no-print">
    <button onclick="window.print()" class="btn btn-primary">
        <i data-lucide="printer"></i> Print Official Municipal Poster (A4)
    </button>
    <a href="{{ $registrationUrl }}" target="_blank" class="btn btn-secondary">
        <i data-lucide="external-link"></i> Test QR Registration Link
    </a>
</div>

<!-- Printable Poster Container -->
<div class="panel-card" style="max-width: 700px; margin: 0 auto; padding: 40px; text-align: center; border-top: 8px solid var(--peso-blue);">
    <!-- Official Header -->
    <div style="display: flex; align-items: center; justify-content: center; gap: 16px; margin-bottom: 20px;">
        <img src="{{ asset('images/peso-logo.svg') }}" alt="PESO Logo" style="width: 70px; height: 70px;">
        <div style="text-align: left;">
            <h3 style="font-size: 13px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; margin: 0;">MUNICIPALITY OF AGOO, LA UNION</h3>
            <h1 style="font-size: 20px; font-weight: 800; color: var(--peso-blue-dark); margin: 2px 0;">PUBLIC EMPLOYMENT SERVICE OFFICE</h1>
            <span class="badge badge-red" style="font-size: 11px;">OFFICIAL APPLICANT REGISTRATION PORTAL</span>
        </div>
    </div>

    <div style="background: var(--peso-blue-light); padding: 14px; border-radius: var(--radius-md); font-size: 14px; font-weight: 700; color: var(--peso-blue); margin-bottom: 24px;">
        📲 SCAN QR CODE TO SUBMIT EMPLOYMENT APPLICATION ONLINE
    </div>

    <!-- Generated QR Code Graphics -->
    <div style="background: #FFFFFF; border: 4px solid var(--peso-blue); display: inline-block; padding: 24px; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); margin-bottom: 24px;">
        <!-- Clean SVG QR Code Representation -->
        <svg width="220" height="220" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <rect width="200" height="200" fill="#FFFFFF"/>
            <!-- Corner Finder 1 -->
            <rect x="10" y="10" width="50" height="50" fill="#0D3B66"/>
            <rect x="20" y="20" width="30" height="30" fill="#FFFFFF"/>
            <rect x="28" y="28" width="14" height="14" fill="#0D3B66"/>

            <!-- Corner Finder 2 -->
            <rect x="140" y="10" width="50" height="50" fill="#0D3B66"/>
            <rect x="150" y="20" width="30" height="30" fill="#FFFFFF"/>
            <rect x="158" y="28" width="14" height="14" fill="#0D3B66"/>

            <!-- Corner Finder 3 -->
            <rect x="10" y="140" width="50" height="50" fill="#0D3B66"/>
            <rect x="20" y="150" width="30" height="30" fill="#FFFFFF"/>
            <rect x="28" y="158" width="14" height="14" fill="#0D3B66"/>

            <!-- Data Modules Pattern -->
            <rect x="70" y="10" width="12" height="12" fill="#0D3B66"/>
            <rect x="90" y="10" width="12" height="24" fill="#0D3B66"/>
            <rect x="110" y="20" width="18" height="12" fill="#D90429"/>
            <rect x="70" y="35" width="24" height="12" fill="#0D3B66"/>
            <rect x="105" y="35" width="24" height="12" fill="#0D3B66"/>

            <rect x="10" y="70" width="24" height="12" fill="#0D3B66"/>
            <rect x="40" y="70" width="12" height="24" fill="#0D3B66"/>
            <rect x="60" y="60" width="80" height="80" fill="#0D3B66" rx="8"/>
            <rect x="70" y="70" width="60" height="60" fill="#FFFFFF" rx="4"/>
            <!-- Center PESO Icon -->
            <circle cx="100" cy="100" r="18" fill="#FFB703"/>
            <path d="M 92,100 L 108,100 M 100,92 L 100,108" stroke="#0B2545" stroke-width="4" stroke-linecap="round"/>

            <rect x="150" y="70" width="24" height="12" fill="#D90429"/>
            <rect x="160" y="90" width="30" height="12" fill="#0D3B66"/>
            <rect x="140" y="110" width="20" height="20" fill="#0D3B66"/>

            <rect x="70" y="150" width="24" height="24" fill="#0D3B66"/>
            <rect x="100" y="150" width="30" height="12" fill="#D90429"/>
            <rect x="140" y="150" width="45" height="12" fill="#0D3B66"/>
            <rect x="150" y="170" width="24" height="20" fill="#0D3B66"/>
            <rect x="110" y="170" width="30" height="14" fill="#0D3B66"/>
        </svg>

        <div style="margin-top: 10px; font-size: 11px; font-weight: 700; color: var(--peso-blue);">
            PESO AGOO DIGITAL PORTAL
        </div>
    </div>

    <!-- Portal URL Display -->
    <div style="font-size: 13px; color: var(--text-secondary); margin-bottom: 20px;">
        Direct URL: <strong style="color: var(--peso-blue-dark);">{{ $registrationUrl }}</strong>
    </div>

    <!-- Instructions for Applicants -->
    <div style="background: #FAFAFA; border: 1px solid var(--border-color); padding: 18px; border-radius: var(--radius-md); text-align: left; font-size: 13px;">
        <strong style="color: var(--peso-blue-dark); font-size: 14px; display: block; margin-bottom: 6px;">
            📌 Applicant Instructions:
        </strong>
        <ol style="margin-left: 20px; line-height: 1.6; color: var(--text-primary);">
            <li>Open your smartphone camera or QR Code Scanner app.</li>
            <li>Point camera at the QR Code above.</li>
            <li>Tap the notification link to open the online registration form.</li>
            <li>Fill in your personal details and select program (GIP, Job Referral, SPES).</li>
            <li>Submit and save your Reference Receipt.</li>
        </ol>
    </div>

    <div style="margin-top: 30px; font-size: 11px; color: var(--text-muted);">
        Public Employment Service Office &bull; Agoo Municipal Hall &bull; Province of La Union
    </div>
</div>
@endsection
