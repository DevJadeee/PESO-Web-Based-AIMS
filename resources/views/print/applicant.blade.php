<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Applicant Record - {{ $applicant->applicant_code }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000000;
            background: #FFFFFF;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-bottom: 2px solid #0D3B66;
            padding-bottom: 10px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-cell {
            width: 80px;
            text-align: center;
        }
        .logo-cell img {
            width: 70px;
            height: 70px;
        }
        .text-cell {
            text-align: center;
        }
        .text-cell h3 {
            margin: 0;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .text-cell h2 {
            margin: 2px 0;
            font-size: 14px;
            color: #0D3B66;
        }
        .text-cell h1 {
            margin: 4px 0;
            font-size: 16px;
            color: #0B2545;
        }
        .section-title {
            background: #0D3B66;
            color: #FFFFFF;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-grid td {
            padding: 6px 8px;
            border: 1px solid #CCCCCC;
            font-size: 11px;
        }
        .info-label {
            font-weight: bold;
            background: #F1F5F9;
            width: 25%;
            color: #333333;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #0D3B66;
            color: #FFFFFF;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }
        @media print {
            .print-btn { display: none !important; }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-btn">🖨️ Print Form (A4)</button>

    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ asset('images/peso-logo.svg') }}" alt="PESO Logo">
            </td>
            <td class="text-cell">
                <h3>Republic of the Philippines &bull; Province of La Union</h3>
                <h2>MUNICIPALITY OF AGOO</h2>
                <h1>PUBLIC EMPLOYMENT SERVICE OFFICE (PESO)</h1>
                <div style="font-size: 11px; font-weight: bold; color: #D90429; margin-top: 4px;">OFFICIAL APPLICANT PROFILE RECORD</div>
            </td>
            <td class="logo-cell">
                <div style="font-size: 10px; border: 1px stroke #0D3B66; padding: 4px; font-weight: bold; background: #F8FAFC;">
                    CODE:<br>{{ $applicant->applicant_code }}
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">I. Personal Information</div>
    <table class="info-grid">
        <tr>
            <td class="info-label">Full Name:</td>
            <td><strong>{{ $applicant->full_name }}</strong></td>
            <td class="info-label">Applicant Code:</td>
            <td>{{ $applicant->applicant_code }}</td>
        </tr>
        <tr>
            <td class="info-label">Date of Birth:</td>
            <td>{{ $applicant->birth_date ? $applicant->birth_date->format('F d, Y') : 'N/A' }}</td>
            <td class="info-label">Gender / Civil Status:</td>
            <td>{{ $applicant->gender ?? 'N/A' }} / {{ $applicant->civil_status ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="info-label">Contact Number:</td>
            <td>{{ $applicant->contact_number }}</td>
            <td class="info-label">Email Address:</td>
            <td>{{ $applicant->email ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="info-label">Barangay:</td>
            <td>{{ $applicant->barangay ?? 'Agoo' }}</td>
            <td class="info-label">Complete Address:</td>
            <td>{{ $applicant->address }}</td>
        </tr>
    </table>

    <div class="section-title">II. Educational Background & Skills</div>
    <table class="info-grid">
        <tr>
            <td class="info-label">Educational Attainment:</td>
            <td>{{ $applicant->educational_attainment }}</td>
            <td class="info-label">Course / Major:</td>
            <td>{{ $applicant->course_or_major ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="info-label">Skills & Qualifications:</td>
            <td colspan="3">{{ $applicant->skills ?? 'None specified' }}</td>
        </tr>
        <tr>
            <td class="info-label">Emergency Contact Person:</td>
            <td>{{ $applicant->emergency_contact_name ?? 'N/A' }}</td>
            <td class="info-label">Emergency Phone Number:</td>
            <td>{{ $applicant->emergency_contact_number ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-title">III. Employment Program Applications History</div>
    <table class="info-grid">
        <tr style="background: #E2E8F0; font-weight: bold;">
            <td>Application No.</td>
            <td>Program</td>
            <td>Purpose / Position Requested</td>
            <td>Submission Date</td>
            <td>Status</td>
        </tr>
        @forelse($applicant->applications as $app)
            <tr>
                <td>{{ $app->application_number }}</td>
                <td>{{ $app->program->name ?? $app->program->code }}</td>
                <td>{{ $app->purpose_or_position }}</td>
                <td>{{ $app->submission_date ? $app->submission_date->format('Y-m-d') : 'N/A' }}</td>
                <td>{{ $app->status }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #666;">No program applications recorded.</td>
            </tr>
        @endforelse
    </table>

    <br><br>
    <table style="width: 100%; margin-top: 30px;">
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="border-bottom: 1px solid #000; width: 220px; margin: 0 auto; padding-bottom: 2px;">
                    <strong>{{ $applicant->full_name }}</strong>
                </div>
                <div style="font-size: 11px; margin-top: 4px;">Applicant Signature</div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="border-bottom: 1px solid #000; width: 220px; margin: 0 auto; padding-bottom: 2px;">
                    <strong>PESO Officer / Receiving Staff</strong>
                </div>
                <div style="font-size: 11px; margin-top: 4px;">Public Employment Service Office</div>
            </td>
        </tr>
    </table>
</body>
</html>
