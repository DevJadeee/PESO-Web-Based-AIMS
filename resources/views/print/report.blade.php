<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PESO Summary Report - Agoo, La Union</title>
    <style>
        @page { size: A4 portrait; margin: 12mm; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #000; background: #FFF; margin: 0; padding: 0; }
        .header-table { width: 100%; border-collapse: collapse; border-bottom: 2px solid #0D3B66; padding-bottom: 8px; margin-bottom: 15px; }
        .header-table td { vertical-align: middle; }
        .logo-cell { width: 70px; text-align: center; }
        .logo-cell img { width: 60px; height: 60px; }
        .text-cell { text-align: center; }
        .text-cell h3 { margin: 0; font-size: 10px; text-transform: uppercase; }
        .text-cell h2 { margin: 2px 0; font-size: 13px; color: #0D3B66; }
        .text-cell h1 { margin: 3px 0; font-size: 15px; color: #0B2545; }
        .report-meta { margin-bottom: 12px; font-size: 11px; display: flex; justify-content: space-between; border-bottom: 1px solid #CBD5E1; padding-bottom: 6px; }
        .data-table { width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 20px; }
        .data-table th { background: #0D3B66; color: #FFF; padding: 6px; border: 1px solid #0D3B66; text-align: left; }
        .data-table td { padding: 5px 6px; border: 1px solid #CBD5E1; }
        .data-table tr:nth-child(even) { background: #F8FAFC; }
        .print-btn { position: fixed; top: 20px; right: 20px; background: #0D3B66; color: #FFF; border: none; padding: 8px 16px; font-weight: bold; border-radius: 4px; cursor: pointer; }
        @media print { .print-btn { display: none !important; } }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-btn">🖨️ Print Summary Report (A4)</button>

    <table class="header-table">
        <tr>
            <td class="logo-cell"><img src="{{ asset('images/peso-logo.svg') }}" alt="PESO Logo"></td>
            <td class="text-cell">
                <h3>Republic of the Philippines &bull; Province of La Union</h3>
                <h2>MUNICIPALITY OF AGOO</h2>
                <h1>PUBLIC EMPLOYMENT SERVICE OFFICE (PESO)</h1>
                <div style="font-size: 11px; font-weight: bold; color: #D90429; margin-top: 3px;">
                    EMPLOYMENT ASSISTANCE SUMMARY REPORT
                </div>
            </td>
            <td class="logo-cell">
                <div style="font-size: 9px; font-weight: bold;">
                    DATE:<br>{{ date('M d, Y') }}
                </div>
            </td>
        </tr>
    </table>

    <div class="report-meta">
        <div><strong>Reporting Period:</strong> {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}</div>
        <div><strong>Program Filter:</strong> {{ $selectedProgram ? $selectedProgram->name : 'All Programs (GIP, JOB, SPES)' }}</div>
        <div><strong>Total Records:</strong> {{ $applications->count() }}</div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>App Number</th>
                <th>Submission Date</th>
                <th>Applicant Code</th>
                <th>Full Name</th>
                <th>Contact Number</th>
                <th>Barangay</th>
                <th>Program</th>
                <th>Purpose / Position</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $index => $app)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $app->application_number }}</strong></td>
                    <td>{{ $app->submission_date ? $app->submission_date->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $app->applicant->applicant_code ?? 'N/A' }}</td>
                    <td><strong>{{ $app->applicant->full_name ?? 'N/A' }}</strong></td>
                    <td>{{ $app->applicant->contact_number ?? 'N/A' }}</td>
                    <td>{{ $app->applicant->barangay ?? 'Agoo' }}</td>
                    <td>{{ $app->program->code ?? 'N/A' }}</td>
                    <td>{{ $app->purpose_or_position }}</td>
                    <td>{{ $app->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align: center; color: #666; padding: 20px;">No applications found matching report parameters.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br><br>
    <table style="width: 100%; margin-top: 30px;">
        <tr>
            <td style="width: 50%; text-align: center;">
                <div style="border-bottom: 1px solid #000; width: 200px; margin: 0 auto; padding-bottom: 2px;">
                    <strong>Prepared By: Administrative Assistant</strong>
                </div>
                <div style="font-size: 10px; margin-top: 3px;">PESO Office Staff</div>
            </td>
            <td style="width: 50%; text-align: center;">
                <div style="border-bottom: 1px solid #000; width: 200px; margin: 0 auto; padding-bottom: 2px;">
                    <strong>Approved By: PESO Manager</strong>
                </div>
                <div style="font-size: 10px; margin-top: 3px;">Public Employment Service Officer - Agoo</div>
            </td>
        </tr>
    </table>
</body>
</html>
