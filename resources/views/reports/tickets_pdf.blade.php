<!DOCTYPE html>
<html>

<head>
    <title>Tickets Report</title>
    <p class="small">Generated at: {{ now()->format('Y-m-d H:i') }}</p>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 5px;
        }

        p {
            margin: 0;
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
        }

        th {
            background-color: #f0f0f0;
        }

        td.text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Tickets Report</h2>
    <p>Generated at: {{ now()->format('Y-m-d H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Customer Name</th>
                <th>Staff Name</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->customer->name ?? '-' }}</td>
                    <td>{{ $ticket->staff->name ?? '-' }}</td>
                    <td class="text-center">{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</td>
                    <td class="text-center">{{ ucfirst($ticket->priority) }}</td>
                    <td class="text-center">{{ $ticket->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No data available for this report.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
