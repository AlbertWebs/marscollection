<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BookingSetting;

class BookingSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            1 => 'Monday',
            2 => 'Tuesday', 
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ];

        foreach ($days as $dayNumber => $dayName) {
            BookingSetting::updateOrCreate(
                ['day_of_week' => $dayNumber],
                [
                    'is_disabled' => $dayNumber == 7, // Sunday disabled by default
                    'disabled_hours' => [],
                    'business_hours_start' => $dayNumber == 7 ? null : '09:00',
                    'business_hours_end' => $dayNumber == 7 ? null : '17:00',
                    'slot_duration' => 60,
                    'break_start' => $dayNumber == 7 ? null : '12:00',
                    'break_end' => $dayNumber == 7 ? null : '13:00',
                ]
            );
        }
    }
}
