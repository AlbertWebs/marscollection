<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\BookingSetting;
use App\Mail\AppointmentBooked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AppointmentController extends Controller
{


    public function create()
    {
        $services = Service::active()->ordered()->get();
        
        $serviceTypes = $services->pluck('name', 'slug')->toArray();
        $serviceDescriptions = $services->pluck('description', 'slug')->toArray();
        $prices = $services->pluck('price', 'slug')->toArray();

        return view('appointments.create', compact('serviceTypes', 'serviceDescriptions', 'prices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'service_type' => 'required|string|exists:services,slug',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        // Check if the time slot is available based on booking settings
        $date = Carbon::parse($request->appointment_date);
        if (!BookingSetting::isTimeSlotAvailable($date, $request->appointment_time)) {
            return back()->withErrors(['appointment_time' => 'This time slot is not available for booking.']);
        }

        // Check if the time slot is already booked
        $existingAppointment = Appointment::where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked. Please choose another time.']);
        }

        $service = Service::where('slug', $request->service_type)->first();

        $appointment = Appointment::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'service_type' => $request->service_type,
            'service_description' => $service->description,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'duration' => $service->duration,
            'price' => $service->price,
            'special_requests' => $request->special_requests,
            'status' => 'pending',
        ]);

        // Send email notification to admin
        try {
            Mail::to(\App\Models\Setting::get('email_admin', 'admin@zaynsbeauty.com'))->send(new AppointmentBooked($appointment));
        } catch (\Exception $e) {
            // Log error but don't fail the booking
            \Illuminate\Support\Facades\Log::error('Failed to send admin notification email: ' . $e->getMessage());
        }

        // Send email notification to customer
        try {
            Mail::to($appointment->customer_email)->send(new \App\Mail\AppointmentPendingCustomer($appointment));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send customer notification email: ' . $e->getMessage());
        }

        // Send WhatsApp notification to admin
        try {
            $adminPhone = \App\Models\Setting::get('contact_phone_primary', '254723343392');
            $serviceName = \App\Models\Service::where('slug', $appointment->service_type)->first()->name ?? 'Service';
            $date = \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y');
            $time = \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A');
            
            $message = "Hello Zayns, a new booking just happened for *{$serviceName}* on *{$date}* at *{$time}* by *{$appointment->customer_name}*. Please check the admin panel for details.";
            
            \App\Services\WhatsAppService::sendMessage($adminPhone, $message);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send WhatsApp notification: ' . $e->getMessage());
        }

        return redirect()->route('appointments.success')
            ->with('success', 'Appointment booked successfully! We will contact you to confirm.');
    }

    public function success()
    {
        return view('appointments.success');
    }

    public function calendar()
    {
        $appointments = Appointment::where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return view('appointments.calendar', compact('appointments'));
    }



    public function checkAvailability(Request $request)
    {
        $date = Carbon::parse($request->date);
        $time = $request->time;

        // Check if time slot is available based on booking settings
        if (!BookingSetting::isTimeSlotAvailable($date, $time)) {
            return response()->json([
                'available' => false,
                'message' => 'This time slot is not available for booking.'
            ]);
        }

        // Check if time slot is already booked
        $existingAppointment = Appointment::where('appointment_date', $request->date)
            ->where('appointment_time', $time)
            ->where('status', '!=', 'cancelled')
            ->first();

        return response()->json([
            'available' => !$existingAppointment,
            'message' => $existingAppointment ? 'This time slot is already booked.' : 'Time slot is available.'
        ]);
    }

    public function getAvailableSlots(Request $request)
    {
        $date = Carbon::parse($request->date);
        
        // Get available slots based on booking settings
        $availableSlots = BookingSetting::getAvailableTimeSlots($date);

        // Get booked slots for the date
        $bookedSlots = Appointment::where('appointment_date', $request->date)
            ->where('status', '!=', 'cancelled')
            ->pluck('appointment_time')
            ->map(function($time) {
                return $time->format('H:i');
            })
            ->toArray();

        // Filter out booked slots
        $availableSlots = array_diff($availableSlots, $bookedSlots);

        return response()->json([
            'available_slots' => array_values($availableSlots),
            'booked_slots' => $bookedSlots
        ]);
    }
}
