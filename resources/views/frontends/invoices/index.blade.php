<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <title>Invoice - Synbio Belanja Buah & Sayur</title>
    <link rel="shortcut icon" href="{{ asset('frontends/assets/favicon.png') }}" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            /* padding: 20px; */
        }
        .row {
            display: flex;
            justify-content: space-between;
            /* margin-bottom: 20px; */
        }
        .col {
            flex: 1;
        }
        .text-end {
            text-align: right;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 20px; */
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 4px;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h3>Invoice</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h5>Order Details</h5>
                <p><strong>Invoice Number:</strong> {{ $order->invoice_number }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>Status:</strong> {{ $order->status == 'SUCCESS' ? 'Lunas' : $order->status }}</p>
            </div>
            <div class="col-lg-6 text-end">
                <h5>Customer Details</h5>
                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h5>Order Payment & Shipping</h5>
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>Payment Method</th>
                            <th>Shipping Method</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td class="text-center">{{ $order->bank->bank_name }} - {{ $order->bank->account_number }}</td>
                                <td class="text-center">{{ $order->courier->name }} - {{ moneyFormat($order->courier->cost) }}</td>
                            </tr>
                    </tbody>
                </table>
                <h5>Order Items</h5>
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Weight</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->title }}</td>
                                <td>{{ $item->weight }}kg</td>
                                <td class="text-end">{{ moneyFormat($item->product->price) }}</td>
                                <td class="text-end">{{ moneyFormat($item->product->price * $item->weight) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col text-end">
                <h5>Payment Summary</h5>
                <p><strong>Total Price:</strong> {{ moneyFormat($order->orderItems->sum('price')) }}</p>
                <p><strong>Shipping Cost:</strong> {{ moneyFormat($order->shipping_cost) }}</p>
                <h4><strong>Total Amount:</strong> {{ moneyFormat($order->total_price + $order->shipping_cost) }}</h4>
            </div>
        </div>
    </div>
</body>
</html>