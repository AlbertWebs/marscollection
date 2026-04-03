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

        // Otherwise, treat as S3 storage path
        return \Storage::disk('s3')->url($imagePath);
    }
} 