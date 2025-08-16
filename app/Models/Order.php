<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'billing_address',
        'subtotal',
        'tax',
        'shipping_cost',
        'total',
        'status',
        'payment_method',
        'notes'
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class)->with(['product', 'bundle']);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class)->with(['product', 'bundle']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reviewLink()
    {
        return $this->hasOne(ReviewLink::class);
    }

    public function getFormattedTotalAttribute()
    {
        return 'KES ' . number_format($this->total, 0);
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'KES ' . number_format($this->subtotal, 0);
    }

    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];

        return $statuses[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
} 