<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'public_id', 'order_id', 'user_id', 'reference', 'cart_session_id',
        'customer_name', 'customer_email', 'phone', 'method', 'provider', 'source',
        'amount', 'currency', 'status', 'provider_request_id', 'provider_request_url',
        'provider_reference', 'failure_reason', 'admin_note', 'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Payment $payment) {
            $payment->public_id ??= (string) Str::uuid();
            $payment->reference ??= 'PAY-' . Str::upper(Str::random(10));
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedAmountAttribute(): string
    {
        return $this->currency . ' ' . number_format((float) $this->amount, 2);
    }
}
