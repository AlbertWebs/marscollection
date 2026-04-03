<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #ec4899, #8b5cf6); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .status-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; border: 2px solid #f3f4f6; }
        .status-text { font-size: 24px; font-weight: bold; color: #ec4899; text-transform: capitalize; }
        .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Update on Your Order</h1>
            <p>Order #{{ $order->order_number }}</p>
        </div>
        
        <div class="content">
            <p>Hi {{ $order->customer_name }},</p>
            <p>The status of your recent order has been updated.</p>
            
            <div class="status-box">
                <p style="margin: 0; color: #6b7280; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">Current Status</p>
                <p class="status-text">{{ $order->status }}</p>
            </div>
            
            @if($order->status === 'shipped')
            <p>Your order is now on its way to you! It is being delivered to:</p>
            <p style="background: #eee; padding: 10px; border-radius: 4px;">
                {{ $order->shipping_address['street'] ?? '' }}<br>
                {{ $order->shipping_address['city'] ?? '' }}
            </p>
            @elseif($order->status === 'delivered')
            <p>Your order has been marked as delivered. We hope you enjoy your purchase!</p>
            @elseif($order->status === 'cancelled')
            <p>We're sorry to inform you that your order has been cancelled. If you have any questions, please reply to this email.</p>
            @else
            <p>We are currently processing your order and will update you once it ships.</p>
            @endif
            
            <p>If you have any questions, please contact us at info@zaynsbeauty.co.ke</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Zayn's Beauty Studio. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
