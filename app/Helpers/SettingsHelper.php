<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingsHelper
{
    /**
     * Get a setting value
     */
    public static function get($key, $default = null)
    {
        return \App\Models\Setting::get($key, $default);
    }

    /**
     * Get contact phone number
     */
    public static function getPhone($type = 'primary')
    {
        return self::get("contact_phone_{$type}");
    }

    /**
     * Get contact email
     */
    public static function getEmail($type = 'primary')
    {
        return self::get("contact_email_{$type}");
    }

    /**
     * Get business address
     */
    public static function getAddress($part = 'full')
    {
        return self::get("contact_address_{$part}");
    }

    /**
     * Get business name
     */
    public static function getBusinessName()
    {
        return self::get('business_name');
    }

    /**
     * Get business hours
     */
    public static function getBusinessHours($day = null)
    {
        if ($day) {
            return self::get("business_hours_{$day}");
        }
        
        return [
            'monday_friday' => self::get('business_hours_monday_friday'),
            'saturday' => self::get('business_hours_saturday'),
            'sunday' => self::get('business_hours_sunday'),
        ];
    }

    /**
     * Get admin email
     */
    public static function getAdminEmail()
    {
        return self::get('email_admin', 'admin@zaynsbeauty.com');
    }

    /**
     * Get specific email by type
     */
    public static function getEmailByType($type)
    {
        return self::get("email_{$type}");
    }

    /**
     * Get all contact information
     */
    public static function getContactInfo()
    {
        return [
            'phone_primary' => self::getPhone('primary'),
            'phone_secondary' => self::getPhone('secondary'),
            'email_primary' => self::getEmail('primary'),
            'email_support' => self::getEmail('support'),
            'email_privacy' => self::getEmailByType('privacy'),
            'email_legal' => self::getEmailByType('legal'),
            'email_returns' => self::getEmailByType('returns'),
            'email_shipping' => self::getEmailByType('shipping'),
            'address_full' => self::getAddress('full'),
            'business_name' => self::getBusinessName(),
        ];
    }
} 