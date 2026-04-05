<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'bundle_id',
        'bundle_name',
        'bundle_price',
        'product_name',
        'product_price',
        'quantity',
        'subtotal',
        'selected_color'
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'bundle_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }

    public function getFormattedPriceAttribute()
    {
        $price = $this->product_price ?? $this->bundle_price;
        return 'KES ' . number_format($price, 0);
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'KES ' . number_format($this->subtotal, 0);
    }

    public function getItemNameAttribute()
    {
        return $this->product_name ?? $this->bundle_name;
    }

    public function getIsBundleAttribute()
    {
        return !is_null($this->bundle_id);
    }

    public function getIsProductAttribute()
    {
        return !is_null($this->product_id);
    }
} 