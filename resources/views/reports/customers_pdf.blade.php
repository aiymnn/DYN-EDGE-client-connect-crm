<!DOCTYPE html>
<html>

<head>
    <title>Customer Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2,
        p {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
        }

        .small {
            font-size: 11px;
            color: #666;
        }
    </style>
</head>

<body>
    <h2>Customer Report</h2>
    <p class="small">Generated at: {{ now()->format('Y-m-d H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Interactions</th>
                <th>Tickets</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->deleted_at ? 'Inactive' : 'Active' }}</td>
                    <td>{{ $customer->interactions_count }}</td>
                    <td>{{ $customer->tickets_count }}</td>
                    <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No customer data available for this filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
