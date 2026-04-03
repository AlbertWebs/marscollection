<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appointment Request</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #ec4899, #8b5cf6); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .details-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border: 2px solid #f3f4f6; }
        .detail-row { display: flex; justify-content: space-between; margin: 10px 0; }
        .label { font-weight: bold; color: #6b7280; }
        .value { color: #111827; }
        .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>We Received Your Request!</h1>
            <p>Your appointment is currently pending confirmation</p>
        </div>
        
        <div class="content">
            <p>Hi {{ $appointment->customer_name }},</p>
            <p>Thank you for submitting an appointment request with Zayn's Beauty! This email confirms we've received your request.</p>
            <p><strong>Note:</strong> Your appointment is not yet confirmed. We will reach out shortly to officially confirm your slot.</p>
            
            <div class="details-box">
                <h3 style="margin-top: 0; color: #ec4899;">Requested Details</h3>
                <div class="detail-row">
                    <span class="label">Date:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Time:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Service:</span>
                    <span class="value">{{ \App\Models\Service::where('slug', $appointment->service_type)->first()->name ?? 'Service' }}</span>
                </div>
            </div>
            
            <p>If you need to make changes, please reply to this email.</p>
            <p>We look forward to spoiling you!</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Zayn's Beauty Studio. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
