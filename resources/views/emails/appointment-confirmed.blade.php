<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appointment Confirmed</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #059669; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .appointment-details { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .detail-row { display: flex; justify-content: space-between; margin: 10px 0; }
        .label { font-weight: bold; color: #6b7280; }
        .value { color: #111827; }
        .button { display: inline-block; background: #10b981; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 5px; }
        .calendar-buttons { text-align: center; margin: 30px 0; }
        .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 14px; }
        .success-icon { font-size: 48px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">✅</div>
            <h1>Appointment Confirmed!</h1>
            <p>Your appointment has been confirmed and is ready to go</p>
        </div>
        
        <div class="content">
            <h2>Appointment Details</h2>
            
            <div class="appointment-details">
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
            
            <div class="calendar-buttons">
                <h3>Add to Your Calendar</h3>
                <p>Click one of the buttons below to add this appointment to your calendar:</p>
                
                @php
                    // Format dates for Google Calendar (YYYYMMDDTHHMMSSZ format)
                    $startDate = $appointment->appointment_date->format('Ymd') . 'T' . $appointment->appointment_time->format('His') . 'Z';
                    $endDate = $appointment->appointment_date->format('Ymd') . 'T' . $appointment->appointment_time->addMinutes($appointment->duration)->format('His') . 'Z';
                    
                    // Google Calendar URL - using the most reliable format
                    $googleCalendarUrl = 'https://calendar.google.com/calendar/render?' . http_build_query([
                        'action' => 'TEMPLATE',
                        'text' => \App\Models\Setting::get('business_name') . ' - ' . $appointment->service_type_label,
                        'dates' => $startDate . '/' . $endDate,
                        'details' => 'Appointment with ' . \App\Models\Setting::get('business_name') . "\n\n" . 
                                   'Service: ' . $appointment->service_type_label . "\n" .
                                   'Duration: ' . $appointment->formatted_duration . "\n" .
                                   'Price: ' . $appointment->formatted_price . "\n\n" .
                                   'Location: ' . \App\Models\Setting::get('contact_address_full') . "\n" .
                                   'Phone: ' . \App\Models\Setting::get('contact_phone_primary'),
                        'location' => \App\Models\Setting::get('contact_address_full'),
                        'sf' => 'true',
                        'output' => 'xml'
                    ]);
                    
                    // Alternative Google Calendar URL format
                    $googleCalendarUrlAlt = 'https://calendar.google.com/calendar/u/0/r/eventedit?' . http_build_query([
                        'text' => \App\Models\Setting::get('business_name') . ' - ' . $appointment->service_type_label,
                        'dates' => $startDate . '/' . $endDate,
                        'details' => 'Appointment with ' . \App\Models\Setting::get('business_name') . "\n\n" . 
                                   'Service: ' . $appointment->service_type_label . "\n" .
                                   'Duration: ' . $appointment->formatted_duration . "\n" .
                                   'Price: ' . $appointment->formatted_price . "\n\n" .
                                   'Location: ' . \App\Models\Setting::get('contact_address_full') . "\n" .
                                   'Phone: ' . \App\Models\Setting::get('contact_phone_primary'),
                        'location' => \App\Models\Setting::get('contact_address_full')
                    ]);
                    
                    // Also create a simple ICS file download as backup
                    $icsContent = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//" . \App\Models\Setting::get('business_name') . "//Appointment//EN
BEGIN:VEVENT
UID:" . uniqid() . "@zaynsbeauty.com
DTSTAMP:" . now()->format('Ymd\THis\Z') . "
DTSTART:" . $appointment->appointment_date->format('Ymd') . 'T' . $appointment->appointment_time->format('His') . "
DTEND:" . $appointment->appointment_date->format('Ymd') . 'T' . $appointment->appointment_time->addMinutes($appointment->duration)->format('His') . "
SUMMARY:" . \App\Models\Setting::get('business_name') . " - " . $appointment->service_type_label . "
DESCRIPTION:Appointment with " . \App\Models\Setting::get('business_name') . "\\n\\nService: " . $appointment->service_type_label . "\\nDuration: " . $appointment->formatted_duration . "\\nPrice: " . $appointment->formatted_price . "\\n\\nLocation: " . \App\Models\Setting::get('contact_address_full') . "\\nPhone: " . \App\Models\Setting::get('contact_phone_primary') . "
LOCATION:" . \App\Models\Setting::get('contact_address_full') . "
END:VEVENT
END:VCALENDAR";
                    
                    // Outlook Calendar URL
                    $outlookCalendarUrl = 'https://outlook.live.com/calendar/0/deeplink/compose?' . http_build_query([
                        'subject' => \App\Models\Setting::get('business_name') . ' - ' . $appointment->service_type_label,
                        'startdt' => $appointment->appointment_date->format('Y-m-d') . 'T' . $appointment->appointment_time->format('H:i:s'),
                        'enddt' => $appointment->appointment_date->format('Y-m-d') . 'T' . $appointment->appointment_time->addMinutes($appointment->duration)->format('H:i:s'),
                        'body' => 'Appointment with ' . \App\Models\Setting::get('business_name') . "\n\n" . 
                                 'Service: ' . $appointment->service_type_label . "\n" .
                                 'Duration: ' . $appointment->formatted_duration . "\n" .
                                 'Price: ' . $appointment->formatted_price . "\n\n" .
                                 'Location: ' . \App\Models\Setting::get('contact_address_full') . "\n" .
                                 'Phone: ' . \App\Models\Setting::get('contact_phone_primary'),
                        'location' => \App\Models\Setting::get('contact_address_full')
                    ]);
                @endphp
                
                <a href="data:text/calendar;charset=utf8,{{ urlencode($icsContent) }}" class="button" download="appointment.ics">
                    Download Calendar File (Works with all calendars)
                </a>
                
                <p style="font-size: 12px; color: #6b7280; margin-top: 10px;">
                    Tip: Download the calendar file above and open it with your preferred calendar app (Google Calendar, Outlook, Apple Calendar, etc.)
                </p>
            </div>
            
            <div style="background: #f0f9ff; border: 1px solid #0ea5e9; border-radius: 8px; padding: 20px; margin: 20px 0;">
                <h3 style="color: #0c4a6e; margin-top: 0;">Important Reminders</h3>
                <ul style="color: #0c4a6e; margin: 10px 0; padding-left: 20px;">
                    <li>Please arrive 10 minutes before your appointment time</li>
                    <li>Bring any reference photos if you have a specific look in mind</li>
                    <li>Mention any skin sensitivities or allergies to your makeup artist</li>
                    <li>Contact us at {{ \App\Models\Setting::get('contact_phone_primary') }} if you need to reschedule</li>
                </ul>
            </div>
        </div>
        
        <div class="footer">
            <p>Thank you for choosing Zayn's Beauty!</p>
            <p>If you have any questions, please contact us at {{ \App\Models\Setting::get('contact_email_primary') }}</p>
        </div>
    </div>
</body>
</html> 