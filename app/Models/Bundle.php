<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'original_price',
        'image',
        'badge',
        'badge_color',
        'is_featured',
        'is_trending',
        'sold_count',
        'rating',
        'review_count',
        'category',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'bundle_items')->withPivot('quantity');
    }

    public function bundleItems()
    {
        return $this->hasMany(BundleItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getAverageRatingAttribute()
    {
        return $this->rating ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->attributes['review_count'] ?? 0;
    }

    /**
     * Update review statistics for this bundle
     */
    public function updateReviewStatistics()
    {
        $reviewsCount = $this->reviews()->count();
        $averageRating = $this->reviews()->avg('rating') ?? 0;
        
        $this->update([
            'review_count' => $reviewsCount,
            'rating' => $averageRating
        ]);
    }

    public function getFormattedPriceAttribute()
    {
        return 'KES ' . number_format($this->price, 0);
    }

    public function getFormattedOriginalPriceAttribute()
    {
        return $this->original_price ? 'KES ' . number_format($this->original_price, 0) : null;
    }

    public function getFormattedSoldCountAttribute()
    {
        if ($this->sold_count >= 1000) {
            return number_format($this->sold_count / 1000, 1) . 'K';
        }
        return $this->sold_count;
    }
}
