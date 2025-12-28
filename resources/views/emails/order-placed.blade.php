<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

    <h2>New Order Placed</h2>

    <p><strong>Order Code:</strong> {{ $order->order_code }}</p>
    <p><strong>Total Amount:</strong> ₹{{ number_format($order->total, 2) }}</p>
    <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_mod) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

    <hr>

    <h4>Customer Details</h4>
    <p><strong>Name:</strong> {{ optional($order->user)->name ?? 'Guest' }}</p>
    <p><strong>Email:</strong> {{ optional($order->user)->email ?? 'N/A' }}</p>
    <p><strong>Phone:</strong> {{ optional($order->user)->phone ?? 'N/A' }}</p>

    <br>
    <p>— LayerLoop Orders System</p>

</body>
</html>
