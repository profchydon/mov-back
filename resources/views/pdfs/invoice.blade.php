<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff; /* Light Blue */
            color: #101828; /* White */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff; /* White */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2{
            color: #004CCC; /* Royal Blue */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #87ceeb; /* Sky Blue */
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #004CCC; /* Royal Blue */
            color: #ffffff; /* White */
        }

        .status-paid {
            color: #008000; /* Green */
        }

        .status-pending {
            color: #ff8c00; /* Dark Orange */
        }

        .status-overdue {
            color: #ff0000; /* Red */
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Invoice Details</h1>

    <table>
        <tr>
            <th>Company Name</th>
            <td>{{ $invoice->company->name }}</td>
        </tr>
        <tr>
            <th>Sub Total</th>
            <td>{{$invoice->currency_code}} {{ number_format($invoice->sub_total) }}</td>
        </tr>
        <tr>
            <th>Tax</th>
            <td>{{$invoice->currency_code}} {{ number_format($invoice->tax) }}</td>
        </tr>
        <tr>
            <th>Carryover Balance</th>
            <td>{{$invoice->currency_code}} {{ number_format($invoice->carry_over) }}</td>
        </tr>
        <tr>
            <th>Total</th>
            <td>{{$invoice->currency_code}} {{ number_format($invoice->sub_total + $invoice->tax) }}</td>
        </tr>
        <tr>
            <th>Date Due</th>
            <td>{{ $invoice->due_at->format('Y-m-d H:i a') }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td class="@if($invoice->status === 'paid') status-paid @elseif($invoice->status === 'pending') status-pending @else status-overdue @endif">
                {{ ucfirst($invoice->status->value) }}
            </td>
        </tr>
    </table>

    <h2>Invoice Items</h2>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Amount</th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoice->items as $item)
            <tr>
                <td>{{ $item->item->name }} {{ucwords($item->item->invoice_type())}}</td>
                <td>{{$invoice->currency_code}} {{ number_format($item->amount) }}</td>
                <td>{{ $item->quantity }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
