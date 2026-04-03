<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Order Received</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #ec4899; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .details-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border: 2px solid #f3f4f6; }
        .detail-row { display: flex; justify-content: space-between; margin: 10px 0; }
        .label { font-weight: bold; color: #6b7280; }
        .value { color: #111827; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .items-table th, .items-table td { padding: 10px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        .items-table th { color: #6b7280; font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 14px; }
        .button { display: inline-block; background: #ec4899; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Order Received</h1>
            <p>Order #{{ $order->order_number }}</p>
        </div>
        
        <div class="content">
            <p>Admin,</p>
            <p>A new order has been successfully placed by <strong>{{ $order->customer_name }}</strong>.</p>
            
            <div class="details-box">
                <h3 style="margin-top: 0; color: #ec4899; border-bottom: 1px solid #eee; padding-bottom: 10px;">Order Details</h3>
                <div class="detail-row">
                    <span class="label">Date:</span>
                    <span class="value">{{ $order->created_at->format('M d, Y g:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Customer Phone:</span>
                    <span class="value">{{ $order->customer_phone }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Customer Email:</span>
                    <span class="value">{{ $order->customer_email }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Payment Method:</span>
                    <span class="value">{{ str_replace('_', ' ', \Illuminate\Support\Str::title($order->payment_method)) }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Delivery Address:</span>
                    <span class="value">{{ $order->shipping_address['street'] ?? '' }}, {{ $order->shipping_address['city'] ?? '' }}</span>
                </div>

                <h3 style="margin-top: 25px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Items Ordered</h3>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
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
                    <span class="label">Order Subtotal:</span>
                    <span class="value">KES {{ number_format($order->subtotal) }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Shipping Cost:</span>
                    <span class="value">KES {{ number_format($order->shipping_cost) }}</span>
                </div>
                <div class="detail-row" style="font-size: 18px; border-top: 1px solid #eee; padding-top: 10px; margin-top: 10px;">
                    <span class="label" style="color: #ec4899;">Grand Total:</span>
                    <span class="value" style="font-weight: bold;">KES {{ number_format($order->total) }}</span>
                </div>
            </div>

            @if($order->notes)
            <div class="details-box">
                <h3 style="margin-top: 0; color: #6b7280;">Customer Notes</h3>
                <p style="margin: 0; font-style: italic;">"{{ $order->notes }}"</p>
            </div>
            @endif
            
            <div style="text-align: center;">
                <a href="{{ route('admin.orders.show', $order) }}" class="button">
                    View Order in Admin Panel
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p>This is an automated notification from Zayn's Beauty Studio Engine.</p>
        </div>
    </div>
</body>
</html> 