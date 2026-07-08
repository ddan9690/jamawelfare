<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contribution Report - {{ $case->member->user->name }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        
        /* Header Section */
        .header { text-align: center; border-bottom: 2px solid #064e3b; padding-bottom: 15px; margin-bottom: 20px; }
        .logo { max-width: 80px; margin-bottom: 8px; }
        .welfare-name { font-size: 18px; font-weight: 800; text-transform: uppercase; margin: 0; color: #064e3b; }
        .report-title { font-size: 14px; text-transform: uppercase; color: #555; margin-top: 4px; font-weight: bold; }
        
        /* Info Section */
        .case-info { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .case-info table { width: 100%; }
        .case-info td { padding: 3px 0; border: none; font-size: 12px; }
        .label { font-weight: bold; color: #064e3b; width: 30%; }
        
        /* Table Section */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #064e3b; color: white; padding: 8px 6px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { border: 1px solid #e5e7eb; padding: 7px 6px; font-size: 10px; }
        tr:nth-child(even) { background-color: #f9fafb; }
        
        /* Summary Section */
        .summary { text-align: center; margin-top: 25px; padding: 15px; background-color: #f0fdfa; border: 1px solid #064e3b; font-size: 14px; font-weight: 900; color: #064e3b; }
        
        .footer { position: fixed; bottom: 0; width: 100%; font-size: 9px; color: #777; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        {{-- @if($case->welfare->logo)
            <img src="{{ public_path('storage/' . $case->welfare->logo) }}" class="logo">
        @endif --}}
        <div class="welfare-name">
            {{ strtoupper($case->welfare->name) }} ({{ strtoupper($case->welfare->abbreviation) }})
        </div>
        <div class="report-title">Benevolence Contribution Report</div>
    </div>

    <div class="case-info">
        <table>
            <tr>
                <td class="label">Affected Member:</td>
                <td>{{ $case->member->user->name }} ({{ $case->member->member_number }})</td>
            </tr>
            <tr>
                <td class="label">Category:</td>
                <td>{{ $case->category->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Status:</td>
                <td>{{ strtoupper($case->status) }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Mem No</th>
                <th>Member Name</th>
                <th>Amount (Ksh)</th>
                <th>Method</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($case->contributions as $index => $c)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $c->member->member_number }}</td>
                    <td>{{ $c->member->user->name }}</td>
                    <td>{{ number_format($c->amount, 0) }}</td>
                    <td>{{ strtoupper($c->payment_type) }}</td>
                    <td>{{ \Carbon\Carbon::parse($c->payment_date)->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        Total Collected: Ksh {{ number_format($totalCollected, 0) }}
    </div>

    <div class="footer">
        Generated on {{ date('d/m/Y H:i') }} | Confidential Records
    </div>

</body>
</html>