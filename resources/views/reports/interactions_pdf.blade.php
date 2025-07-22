<!DOCTYPE html>
<html>

<head>
    <title>Interactions Report PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
        }

        h2 {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <h2>Interactions Report</h2>
    <p>Generated at: {{ now()->format('d M Y, h:i A') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Staff Name</th>
                <th>Type</th>
                <th>Notes</th>
                <th>Date</th>
                <th>Time</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($interactions as $interaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $interaction->customer->name ?? '-' }}</td>
                    <td>{{ $interaction->staff->name ?? '-' }}</td>
                    <td>{{ ucfirst($interaction->type) }}</td>
                    <td>{{ $interaction->notes ?? '-' }}</td>
                    <td>
                        {{ $interaction->datetime ? \Carbon\Carbon::parse($interaction->datetime)->format('d M Y') : '-' }}
                    </td>
                    <td>
                        {{ $interaction->datetime ? \Carbon\Carbon::parse($interaction->datetime)->format('h:i A') : '-' }}
                    </td>
                    <td>{{ $interaction->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No data available for this report.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
