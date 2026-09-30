<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Your Order - Mars Collection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #ec4899;
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .button {
            display: inline-block;
            background: #ec4899;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
        }
        .order-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #ec4899;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Review Your Order</h1>
        <p>We'd love to hear about your experience!</p>
    </div>

    <div class="content">
        <h2>Hello {{ $order->customer_name }},</h2>

        <p>Thank you for your recent order with Mars Collection! We hope you're enjoying your products.</p>

        <p>Your feedback is incredibly valuable to us and helps other customers make informed decisions. We'd love to hear about your experience with the products you purchased.</p>

        <div class="order-details">
            <h3>Order Details:</h3>
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
            <p><strong>Total:</strong> {{ $order->formatted_total }}</p>
        </div>

        <p>Please take a moment to review your purchase. Your feedback helps other customers choose their next pair.</p>

        <div style="text-align: center;">
            <a href="{{ $reviewUrl }}" class="button">Review Your Order</a>
        </div>

        <p><strong>Important Notes:</strong></p>
        <ul>
            <li>This review link is unique to your order and will expire in 30 days</li>
            <li>You can review each product and bundle you purchased</li>
            <li>Once you submit a review for an item, you cannot review it again</li>
            <li>Your reviews will be visible on our product pages to help other customers</li>
        </ul>

        <p>If you have any questions or need assistance, please don't hesitate to contact us.</p>

        <p>Thank you for choosing Mars Collection!</p>

        <p>Best regards,<br>
        The Mars Collection Team</p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} Mars Collection. All rights reserved.</p>
        <p>This email was sent to {{ $order->customer_email }}</p>
    </div>
</body>
</html>
