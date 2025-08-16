<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_of_week',
        'is_disabled',
        'disabled_hours',
        'business_hours_start',
        'business_hours_end',
        'slot_duration',
        'break_start',
        'break_end',
    ];

    protected $casts = [
        'is_disabled' => 'boolean',
        'disabled_hours' => 'array',
        'business_hours_start' => 'datetime:H:i',
        'business_hours_end' => 'datetime:H:i',
        'break_start' => 'datetime:H:i',
        'break_end' => 'datetime:H:i',
    ];

    public static function getDaySettings($dayOfWeek)
    {
        return static::where('day_of_week', $dayOfWeek)->first();
    }

    public static function isTimeSlotAvailable($date, $time)
    {
        $dayOfWeek = $date->format('N'); // 1 (Monday) through 7 (Sunday)
        $setting = static::getDaySettings($dayOfWeek);

        if (!$setting || $setting->is_disabled) {
            return false;
        }

        $timeObj = \Carbon\Carbon::parse($time);
        
        // Check if time is within business hours
        if ($setting->business_hours_start && $setting->business_hours_end) {
            if ($timeObj->lt($setting->business_hours_start) || $timeObj->gte($setting->business_hours_end)) {
                return false;
            }
        }

        // Check if time is during break
        if ($setting->break_start && $setting->break_end) {
            if ($timeObj->gte($setting->break_start) && $timeObj->lt($setting->break_end)) {
                return false;
            }
        }

        // Check if time is in disabled hours
        if ($setting->disabled_hours) {
            foreach ($setting->disabled_hours as $disabledHour) {
                if ($timeObj->format('H:i') === $disabledHour) {
                    return false;
                }
            }
        }

        return true;
    }

    public static function getAvailableTimeSlots($date)
    {
        $dayOfWeek = $date->format('N');
        $setting = static::getDaySettings($dayOfWeek);

        if (!$setting || $setting->is_disabled) {
            return [];
        }

        $slots = [];
        $slotDuration = $setting->slot_duration ?? 60; // Default 60 minutes
        $startTime = $setting->business_hours_start ?? \Carbon\Carbon::parse('09:00');
        $endTime = $setting->business_hours_end ?? \Carbon\Carbon::parse('17:00');

        $currentTime = $startTime->copy();

        while ($currentTime->lt($endTime)) {
            // Skip break time
            if ($setting->break_start && $setting->break_end) {
                if ($currentTime->gte($setting->break_start) && $currentTime->lt($setting->break_end)) {
                    $currentTime->addMinutes($slotDuration);
                    continue;
                }
            }

            // Skip disabled hours
            $isDisabled = false;
            if ($setting->disabled_hours) {
                foreach ($setting->disabled_hours as $disabledHour) {
                    if ($currentTime->format('H:i') === $disabledHour) {
                        $isDisabled = true;
                        break;
                    }
                }
            }

            if (!$isDisabled) {
                $slots[] = $currentTime->format('H:i');
            }

            $currentTime->addMinutes($slotDuration);
        }

        return $slots;
    }
} 