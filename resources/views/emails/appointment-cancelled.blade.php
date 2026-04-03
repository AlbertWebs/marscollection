<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appointment Cancelled</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #ef4444, #b91c1c); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .details-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border: 2px solid #fee2e2; }
        .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Appointment Cancelled</h1>
            <p>Your appointment has been cancelled</p>
        </div>
        
        <div class="content">
            <p>Hi {{ $appointment->customer_name }},</p>
            <p>We are writing to let you know that your appointment scheduled for <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') }}</strong> at <strong>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</strong> has been cancelled.</p>
            
            <p>If you would like to reschedule, please visit our website and book a new time slot.</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/book-appointment') }}" style="display: inline-block; background: #ec4899; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px;">
                    Book New Appointment
                </a>
            </div>
            
            <p>If you have any questions, please contact us at info@zaynsbeauty.co.ke</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Zayn's Beauty Studio. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
