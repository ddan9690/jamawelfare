<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Directory - {{ $welfare->name }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        
        /* Header Section */
        .header { text-align: center; border-bottom: 2px solid #064e3b; padding-bottom: 15px; margin-bottom: 20px; }
        .logo { max-width: 80px; margin-bottom: 8px; }
        .welfare-name { font-size: 18px; font-weight: 800; text-transform: uppercase; margin: 0; color: #064e3b; }
        .directory-title { font-size: 14px; text-transform: uppercase; color: #555; margin-top: 4px; font-weight: bold; }
        
        /* Table Section */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #064e3b; color: white; padding: 8px 6px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { border: 1px solid #e5e7eb; padding: 7px 6px; font-size: 10px; }
        tr:nth-child(even) { background-color: #f9fafb; }
        
        /* Status styling */
        .status-active { color: #059669; font-weight: bold; }
        .status-inactive { color: #dc2626; font-weight: bold; }
        
        /* Footer */
        .footer { position: fixed; bottom: 0; width: 100%; font-size: 9px; color: #777; text-align: center; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        @if($welfare->logo_path)
            <img src="{{ public_path('storage/' . $welfare->logo_path) }}" class="logo">
        @endif
        <div class="welfare-name">
            {{ strtoupper($welfare->name) }} ({{ strtoupper($welfare->abbreviation) }})
        </div>
        <div class="directory-title">Member Directory</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Member No.</th>
                <th>Name</th>
                <th>County</th>
                <th>TSC Number</th>
                <th>Phone</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $index => $member)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $member->member_number ?? '-' }}</td>
                    <td>{{ $member->user->name ?? 'N/A' }}</td>
                    <td>{{ $member->user->county->name ?? 'N/A' }}</td>
                    <td>{{ $member->user->tsc_number ?? 'N/A' }}</td>
                    <td>{{ $member->user->phone ?? 'N/A' }}</td>
                    <td class="{{ $member->status === 'active' ? 'status-active' : 'status-inactive' }}">
                        {{ strtoupper($member->status) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ date('d/m/Y H:i') }} | {{ $welfare->name }} Official Records
    </div>

</body>
</html>