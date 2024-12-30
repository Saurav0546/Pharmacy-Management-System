<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Report</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    table th,
    table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    table th {
        background-color: #f2f2f2;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    </style>
</head>

<body>

    <h1>Pharmacy Stock Report</h1>

    <table>
        <thead>
            <tr>
                <th>Medicine Name</th>
                <th>Price (USD)</th>
                <th>Quantity in Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medicines as $medicine)
            <tr>
                <td>{{ $medicine['name'] }}</td>
                <td>{{ $medicine['price'] }}</td>
                <td>{{ $medicine['quantity'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>