<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookingSetting;
use Carbon\Carbon;

class TestBookingSettings extends Command
{
    protected $signature = 'test:booking-settings';
    protected $description = 'Test booking settings functionality';

    public function handle()
    {
        $this->info('Testing Booking Settings...');

        // Test Monday settings
        $monday = Carbon::parse('2024-01-01'); // Monday
        $this->info('Monday (2024-01-01) settings:');
        $this->info('Is 09:00 available: ' . (BookingSetting::isTimeSlotAvailable($monday, '09:00') ? 'Yes' : 'No'));
        $this->info('Is 12:00 available: ' . (BookingSetting::isTimeSlotAvailable($monday, '12:00') ? 'Yes' : 'No'));
        $this->info('Is 18:00 available: ' . (BookingSetting::isTimeSlotAvailable($monday, '18:00') ? 'Yes' : 'No'));

        // Test Sunday settings (should be disabled)
        $sunday = Carbon::parse('2024-01-07'); // Sunday
        $this->info('Sunday (2024-01-07) settings:');
        $this->info('Is 09:00 available: ' . (BookingSetting::isTimeSlotAvailable($sunday, '09:00') ? 'Yes' : 'No'));

        // Test available slots
        $this->info('Available slots for Monday:');
        $slots = BookingSetting::getAvailableTimeSlots($monday);
        foreach ($slots as $slot) {
            $this->info('- ' . $slot);
        }

        $this->info('Test completed!');
    }
} 