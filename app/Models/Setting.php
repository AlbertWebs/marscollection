<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $label = null, $group = 'general', $type = 'string')
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'label' => $label ?? ucfirst(str_replace('_', ' ', $key)),
                'group' => $group,
                'type' => $type,
            ]
        );
    }

    /**
     * Update only the value of an existing setting (preserves group)
     */
    public static function updateValue($key, $value)
    {
        $setting = static::where('key', $key)->first();
        if ($setting) {
            $setting->update(['value' => $value]);
            return $setting;
        }
        return null;
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup($group)
    {
        return static::where('group', $group)->get();
    }

    /**
     * Get contact settings
     */
    public static function getContactSettings()
    {
        return static::getByGroup('contact');
    }

    /**
     * Get business settings
     */
    public static function getBusinessSettings()
    {
        return static::getByGroup('business');
    }
}
