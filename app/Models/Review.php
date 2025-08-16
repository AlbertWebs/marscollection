<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'bundle_id',
        'rating',
        'comment',
        'is_approved'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }

    public function getReviewableAttribute()
    {
        return $this->product ?? $this->bundle;
    }

    public function getReviewableNameAttribute()
    {
        if ($this->product) {
            return $this->product->name;
        }
        if ($this->bundle) {
            return $this->bundle->name;
        }
        return 'Unknown';
    }
}
