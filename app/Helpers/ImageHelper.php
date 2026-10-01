<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Get the correct image URL for a product.
     * Supports external URLs, public files, and cloud storage files.
     */
    public static function getProductImageUrl($imagePath)
    {
        if (!$imagePath) {
            return null;
        }

        if (Str::startsWith($imagePath, 'http')) {
            return $imagePath;
        }

        if (Str::startsWith($imagePath, '/')) {
            return asset(ltrim($imagePath, '/'));
        }

        if (config('filesystems.default') === 's3') {
            return \Storage::disk('s3')->url($imagePath);
        }

        // Product uploads are stored on the public disk. Use the active
        // request's host instead of a potentially stale configured APP_URL.
        return asset('storage/' . ltrim($imagePath, '/'));
    }
}
