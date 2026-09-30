<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Get the correct image URL for a product
     * Supports both external URLs and local storage files
     */
    public static function getProductImageUrl($imagePath)
    {
        if (!$imagePath) {
            return null;
        }

        // If it's already a full URL, return as is
        if (Str::startsWith($imagePath, 'http')) {
            return $imagePath;
        }

        // Paths beginning with a slash refer to files in the public directory.
        if (Str::startsWith($imagePath, '/')) {
            return asset(ltrim($imagePath, '/'));
        }

        // Use the configured cloud disk in production and the public disk locally.
        $disk = config('filesystems.default') === 's3' ? 's3' : 'public';

        return \Storage::disk($disk)->url($imagePath);
    }
}
