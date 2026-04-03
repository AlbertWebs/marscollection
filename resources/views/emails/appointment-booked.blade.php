<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Appointment Booked</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #ec4899; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .appointment-details { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .detail-row { display: flex; justify-content: space-between; margin: 10px 0; }
        .label { font-weight: bold; color: #6b7280; }
        .value { color: #111827; }
        .button { display: inline-block; background: #ec4899; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Appointment Booked</h1>
            <p>A new appointment has been booked and requires your attention</p>
        </div>
        
        <div class="content">
            <h2>Appointment Details</h2>
            
            <div class="appointment-details">
                <div class="detail-row">
                    <span class="label">Customer Name:</span>
                    <span class="value">{{ $appointment->customer_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Email:</span>
                    <span class="value">{{ $appointment->customer_email }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Phone:</span>
                    <span class="value">{{ $appointment->customer_phone }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Service:</span>
                    <span class="value">{{ $appointment->service_type_label }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Date:</span>
                    <span class="value">{{ $appointment->appointment_date->format('l, F d, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Time:</span>
                    <span class="value">{{ $appointment->appointment_time->format('g:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Duration:</span>
                    <span class="value">{{ $appointment->formatted_duration }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Price:</span>
                    <span class="value">{{ $appointment->formatted_price }}</span>
                </div>
                @if($appointment->special_requests)
                <div class="detail-row">
                    <span class="label">Special Requests:</span>
                    <span class="value">{{ $appointment->special_requests }}</span>
                </div>
                @endif
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('admin.appointments.show', $appointment) }}" class="button">
                    View Appointment Details
                </a>
            </div>
            
            <p><strong>Action Required:</strong> Please review this appointment and update its status in the admin panel.</p>
        </div>
        
        <div class="footer">
            <p>This is an automated notification from Zayn's Beauty booking system.</p>
        </div>
    </div>
</body>
</html> 