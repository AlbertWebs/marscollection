<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Order Received</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #ec4899; color: white; padding: 20px; text-align: center; }
        .content { background: #f9fafb; padding: 20px; }
        .order-details { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
        .total { font-weight: bold; font-size: 18px; padding: 15px 0; border-top: 2px solid #eee; }
        .address { background: white; padding: 15px; margin: 10px 0; border-radius: 8px; }
        .button { display: inline-block; background: #ec4899; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Order Received</h1>
            <p>Order #{{ $order->order_number }}</p>
        </div>
        
        <div class="content">
            <h2>Order Details</h2>
            <div class="order-details">
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                @if($order->customer_phone)
                    <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                @endif
                <p><strong>Payment Method:</strong> {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>

            <h2>Order Items</h2>
            <div class="order-details">
                @foreach($order->items as $item)
                    <div class="item">
                        <div>
                            <strong>{{ $item->product_name }}</strong><br>
                            <small>Qty: {{ $item->quantity }}</small>
                        </div>
                        <div>${{ number_format($item->product_price * $item->quantity, 2) }}</div>
                    </div>
                @endforeach
                
                <div class="total">
                    <div class="item">
                        <span>Subtotal:</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="item">
                        <span>Tax (15%):</span>
                        <span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="item">
                        <span>Shipping:</span>
                        <span>${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="item">
                        <span><strong>Total:</strong></span>
                        <span><strong>${{ number_format($order->total, 2) }}</strong></span>
                    </div>
                </div>
            </div>

            <h2>Shipping Address</h2>
            <div class="address">
                <p>{{ $order->customer_name }}</p>
                <p>{{ $order->shipping_address['street'] }}</p>
                <p>{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['zip_code'] }}</p>
                <p>{{ $order->shipping_address['country'] }}</p>
                @if($order->customer_phone)
                    <p>Phone: {{ $order->customer_phone }}</p>
                @endif
            </div>

            @if($order->notes)
                <h2>Order Notes</h2>
                <div class="address">
                    <p>{{ $order->notes }}</p>
                </div>
            @endif

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/admin/orders/' . $order->id) }}" class="button">View Order Details</a>
            </div>
        </div>
    </div>
</body>
</html> 