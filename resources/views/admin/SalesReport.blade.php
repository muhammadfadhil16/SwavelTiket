{{-- sales report pdf --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Sales Report</h1>
    <p>Date: {{ now()->format('Y-m-d') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Total Price</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->id_order }}</td>
                <td>{{ $order->user->name_user}}</td>
                <td>{{ number_format($order->total_price, 2) }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
