<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #ec4899; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .details-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .detail-row { display: flex; justify-content: space-between; margin: 10px 0; }
        .label { font-weight: bold; color: #6b7280; }
        .value { color: #111827; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .items-table th, .items-table td { padding: 10px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        .items-table th { color: #6b7280; font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You For Your Order!</h1>
            <p>We've received your order and are preparing it.</p>
        </div>
        
        <div class="content">
            <p>Hi {{ $order->customer_name }},</p>
            <p>Your order <strong>{{ $order->order_number }}</strong> has been successfully placed. We will notify you again once it has shipped!</p>
            
            <div class="details-box">
                <div class="detail-row">
                    <span class="label">Date:</span>
                    <span class="value">{{ $order->created_at->format('M d, Y g:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Delivery Address:</span>
                    <span class="value">{{ $order->shipping_address['street'] ?? '' }}, {{ $order->shipping_address['city'] ?? '' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Payment Method:</span>
                    <span class="value">{{ str_replace('_', ' ', \Illuminate\Support\Str::title($order->payment_method)) }}</span>
                </div>
                
                <h3 style="margin-top: 25px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Order Summary</h3>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name ?? $item->bundle_name }}</td>
                            <td>x{{ $item->quantity }}</td>
                            <td>KES {{ number_format($item->subtotal) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="detail-row" style="margin-top: 15px;">
                    <span class="label">Subtotal:</span>
                    <span class="value">KES {{ number_format($order->subtotal) }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Shipping:</span>
                    <span class="value">KES {{ number_format($order->shipping_cost) }}</span>
                </div>
                <div class="detail-row" style="font-size: 18px; border-top: 1px solid #eee; padding-top: 10px; margin-top: 10px;">
                    <span class="label" style="color: #ec4899;">Total:</span>
                    <span class="value" style="font-weight: bold;">KES {{ number_format($order->total) }}</span>
                </div>
            </div>
            
            <p>If you have any questions, please contact us at info@zaynsbeauty.co.ke</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Zayn's Beauty Studio. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
