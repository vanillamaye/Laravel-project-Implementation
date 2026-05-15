<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #333; margin: 0; }
        .header { background-color: blue; color: white; padding: 25px; text-align: center; }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .container { padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; table-layout: fixed; }
        th { background-color: #f8fafc; color: #1e293b; border: 1px solid #e2e8f0; padding: 10px; text-align: left; }
        td { border: 1px solid #e2e8f0; padding: 10px; word-wrap: break-word; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; border-top: 3px solid blue; padding-top: 10px; text-align: right; font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Inventory Management Access Report</h1>
        <p>Customer Frontline Solutions - Maye Store Inventory</p>
    </div>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th style="width: 30%;">Product Name</th>
                    <th style="width: 15%;">Supplier</th>
                    <th style="width: 15%; text-align: center;">Date</th>
                    <th style="width: 10%; text-align: center;">Qty</th>
                    <th style="width: 15%; text-align: right;">Cost Price</th>
                    <th style="width: 15%; text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($products as $product)
                @php 
                    $quantity = $product->stocks ?? $product->qty ?? 0;
                    $price = $product->price ?? 0;
                    $amount = $quantity * $price;
                    $grandTotal += $amount;
                @endphp
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->supplier ?? 'N/A' }}</td>
                    <td class="text-center">
                        {{ $product->purchase_date ? \Carbon\Carbon::parse($product->purchase_date)->format('M d, Y') : '-' }}
                    </td>
                    <td class="text-center">{{ $quantity }}</td>
                    <td class="text-right">&#8369;{{ number_format($price, 2) }}</td>
                    <td class="text-right">&#8369;{{ number_format($amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            Total Inventory Value: &#8369;{{ number_format($grandTotal, 2) }}
        </div>
    </div>
</body>
</html>