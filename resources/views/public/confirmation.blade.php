@extends('layouts.public')

@section('title', 'Application Confirmed')

@section('content')
<div style="max-width: 680px; margin: 0 auto; padding: 12px 0 20px; text-align: center;">
    <div style="width: 70px; height: 70px; background: rgba(16, 185, 129, 0.12); color: #15803d; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px;">
        <i data-lucide="check-circle" style="width: 40px; height: 40px;"></i>
    </div>

    <h2 style="font-size: 30px; font-weight: 800; color: var(--peso-blue-dark); letter-spacing: -0.02em; margin: 0;">Application Submitted Successfully</h2>
    <p style="font-size: 14px; color: var(--text-secondary); margin: 10px auto 0; max-width: 560px; line-height: 1.6;">
        Thank you for submitting your application to the Public Employment Service Office (PESO) of Agoo, La Union.
    </p>

    <div style="margin: 26px 0; padding: 18px 20px; border: 1px solid rgba(13, 59, 102, 0.15); border-radius: 14px; background: #F8FAFC; text-align: left;">
        <div style="font-size: 11px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--peso-blue);">Application Reference Number</div>
        <div style="margin-top: 8px; font-size: 30px; font-weight: 800; letter-spacing: 0.08em; color: var(--peso-blue-dark);">{{ $application->application_number }}</div>
        <div style="margin-top: 8px; font-size: 12px; color: var(--text-secondary);">Applicant ID: <strong>{{ $application->applicant->applicant_code }}</strong></div>
    </div>

    <div style="padding: 18px 20px; border: 1px solid var(--border-color); border-radius: 12px; background: #FFFFFF; text-align: left; margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <div style="font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 4px;">Applicant Name</div>
                <strong style="font-size: 15px; color: var(--peso-blue-dark);">{{ $application->applicant->full_name }}</strong>
            </div>
            <div>
                <div style="font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 4px;">Contact Number</div>
                <strong style="font-size: 15px; color: var(--peso-blue-dark);">{{ $application->applicant->contact_number }}</strong>
            </div>
            <div>
                <div style="font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 4px;">Program</div>
                <strong style="font-size: 15px; color: var(--peso-blue-dark);">{{ $application->program->name }} ({{ $application->program->code }})</strong>
            </div>
            <div>
                <div style="font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 4px;">Purpose / Position</div>
                <strong style="font-size: 15px; color: var(--peso-blue-dark);">{{ $application->purpose_or_position }}</strong>
            </div>
        </div>
    </div>

    <div style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(180, 83, 9, 0.12); color: #92400e; padding: 16px 18px; border-radius: 12px; text-align: left; margin-bottom: 22px;">
        <strong style="font-size: 14px; display: block; margin-bottom: 8px;">Next Steps</strong>
        <ol style="margin: 0 0 0 18px; padding: 0; line-height: 1.7; font-size: 13px;">
            <li>Keep a copy of your application reference number for your records.</li>
            <li>Present this reference when visiting the PESO office at Agoo Municipal Hall.</li>
            <li>PESO staff will review your application and contact you for the next steps.</li>
        </ol>
    </div>

    <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
        <a href="{{ route('admin.applications.print', $application->id) }}" target="_blank" class="btn btn-primary">
            <i data-lucide="printer"></i> Print Receipt
        </a>
        <a href="{{ route('public.register') }}" class="btn btn-secondary">
            <i data-lucide="plus"></i> Submit Another Application
        </a>
    </div>
</div>
@endsection
