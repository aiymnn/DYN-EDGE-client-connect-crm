<!DOCTYPE html>
<html>

<head>
    <title>Staff Report PDF</title>
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
    <h2>Staff Report</h2>
    <p>Generated at: {{ now()->format('d M Y, h:i A') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Total Interactions</th>
                <th>Total Tickets</th>
                <th>Status</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($staffs as $staff)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $staff->name }}</td>
                    <td>{{ $staff->email }}</td>
                    <td>{{ $staff->phone ?? '-' }}</td>
                    <td>{{ $staff->role }}</td>
                    <td>{{ $staff->interactions_count }}</td>
                    <td>{{ $staff->tickets_count }}</td>
                    <td>{{ $staff->deleted_at ? 'Inactive' : 'Active' }}</td>
                    <td>{{ $staff->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No data available for this report.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
