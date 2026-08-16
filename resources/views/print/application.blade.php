<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Application Form - {{ $application->application_number }}</title>
    <style>
        @page { size: A4; margin: 15mm; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; background: #FFF; margin: 0; padding: 0; }
        .header-table { width: 100%; border-collapse: collapse; border-bottom: 2px solid #0D3B66; padding-bottom: 10px; margin-bottom: 15px; }
        .header-table td { vertical-align: middle; }
        .logo-cell { width: 80px; text-align: center; }
        .logo-cell img { width: 70px; height: 70px; }
        .text-cell { text-align: center; }
        .text-cell h3 { margin: 0; font-size: 11px; text-transform: uppercase; }
        .text-cell h2 { margin: 2px 0; font-size: 14px; color: #0D3B66; }
        .text-cell h1 { margin: 4px 0; font-size: 16px; color: #0B2545; }
        .box { border: 1px solid #0D3B66; padding: 12px; margin-bottom: 15px; background: #F8FAFC; }
        .box-title { font-weight: bold; color: #0D3B66; font-size: 13px; margin-bottom: 8px; text-transform: uppercase; border-bottom: 1px solid #CBD5E1; padding-bottom: 4px; }
        .grid { width: 100%; border-collapse: collapse; }
        .grid td { padding: 6px 8px; border: 1px solid #E2E8F0; font-size: 11px; }
        .label { font-weight: bold; background: #F1F5F9; width: 25%; color: #333; }
        .print-btn { position: fixed; top: 20px; right: 20px; background: #0D3B66; color: #FFF; border: none; padding: 10px 20px; font-weight: bold; border-radius: 4px; cursor: pointer; }
        @media print { .print-btn { display: none !important; } }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-btn">🖨️ Print Form (A4)</button>

    <table class="header-table">
        <tr>
            <td class="logo-cell"><img src="{{ asset('images/peso-logo.svg') }}" alt="PESO Logo"></td>
            <td class="text-cell">
                <h3>Republic of the Philippines &bull; Province of La Union</h3>
                <h2>MUNICIPALITY OF AGOO</h2>
                <h1>PUBLIC EMPLOYMENT SERVICE OFFICE (PESO)</h1>
                <div style="font-size: 12px; font-weight: bold; color: #D90429; margin-top: 4px;">
                    EMPLOYMENT ASSISTANCE PROGRAM APPLICATION FORM
                </div>
            </td>
            <td class="logo-cell">
                <div style="font-size: 10px; border: 1px stroke #0D3B66; padding: 4px; font-weight: bold; background: #F8FAFC;">
                    APP NO:<br>{{ $application->application_number }}
                </div>
            </td>
        </tr>
    </table>

    <div class="box">
        <div class="box-title">PROGRAM INFORMATION</div>
        <table class="grid">
            <tr>
                <td class="label">Program Name:</td>
                <td><strong>{{ $application->program->name }} ({{ $application->program->code }})</strong></td>
                <td class="label">Application No:</td>
                <td><strong>{{ $application->application_number }}</strong></td>
            </tr>
            <tr>
                <td class="label">Purpose / Position:</td>
                <td>{{ $application->purpose_or_position }}</td>
                <td class="label">Place / Agency:</td>
                <td>{{ $application->place_or_agency ?? 'PESO Agoo' }}</td>
            </tr>
            <tr>
                <td class="label">Date Submitted:</td>
                <td>{{ $application->submission_date ? $application->submission_date->format('F d, Y') : 'N/A' }}</td>
                <td class="label">Time In / Status:</td>
                <td>{{ $application->time_in }} &bull; <strong>{{ $application->status }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="box">
        <div class="box-title">APPLICANT PROFILE DETAILS</div>
        <table class="grid">
            <tr>
                <td class="label">Applicant Code:</td>
                <td><strong>{{ $application->applicant->applicant_code }}</strong></td>
                <td class="label">Full Name:</td>
                <td><strong>{{ $application->applicant->full_name }}</strong></td>
            </tr>
            <tr>
                <td class="label">Contact Number:</td>
                <td>{{ $application->applicant->contact_number }}</td>
                <td class="label">Email Address:</td>
                <td>{{ $application->applicant->email ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Barangay:</td>
                <td>{{ $application->applicant->barangay ?? 'Agoo' }}</td>
                <td class="label">Complete Address:</td>
                <td>{{ $application->applicant->address }}</td>
            </tr>
            <tr>
                <td class="label">Education Level:</td>
                <td>{{ $application->applicant->educational_attainment }}</td>
                <td class="label">Course / Major:</td>
                <td>{{ $application->applicant->course_or_major ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Skills:</td>
                <td colspan="3">{{ $application->applicant->skills ?? 'None specified' }}</td>
            </tr>
        </table>
    </div>

    <br><br>
    <table style="width: 100%; margin-top: 40px;">
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="border-bottom: 1px solid #000; width: 220px; margin: 0 auto; padding-bottom: 2px;">
                    <strong>{{ $application->applicant->full_name }}</strong>
                </div>
                <div style="font-size: 11px; margin-top: 4px;">Applicant Signature</div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="border-bottom: 1px solid #000; width: 220px; margin: 0 auto; padding-bottom: 2px;">
                    <strong>PESO Officer / Authorized Evaluator</strong>
                </div>
                <div style="font-size: 11px; margin-top: 4px;">Public Employment Service Office - Agoo</div>
            </td>
        </tr>
    </table>
</body>
</html>
