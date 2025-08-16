<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReviewLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'unique_token',
        'email',
        'is_used',
        'expires_at'
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function generateToken()
    {
        return Str::random(32);
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isValid()
    {
        return !$this->is_used && !$this->isExpired();
    }
}
