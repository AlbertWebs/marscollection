<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'category_id',
        'brand_id',
        'image',
        'rating',
        'reviews_count',
        'sold_count',
        'badge',
        'badge_color',
        'is_featured',
        'is_trending',
        'is_active',
        'stock_quantity',
        'sku',
        'colors'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'reviews_count' => 'integer',
        'sold_count' => 'integer',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_active' => 'boolean',
        'colors' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = strtoupper(Str::random(3)) . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
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
        return $this->attributes['reviews_count'] ?? 0;
    }

    /**
     * Update review statistics for this product
     */
    public function updateReviewStatistics()
    {
        $reviewsCount = $this->reviews()->count();
        $averageRating = $this->reviews()->avg('rating') ?? 0;
        
        $this->update([
            'reviews_count' => $reviewsCount,
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

    public function getRouteKeyName()
    {
        return 'slug';
    }
} 