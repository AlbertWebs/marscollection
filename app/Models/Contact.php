<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'subject',
        'message',
        'ip_address',
        'user_agent',
        'is_bot',
        'website',
        'company'
    ];

    protected $casts = [
        'is_bot' => 'boolean',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getSubjectDisplayAttribute()
    {
        $subjects = [
            'general' => 'General Inquiry',
            'product' => 'Product Information',
            'order' => 'Order Status',
            'return' => 'Returns & Refunds',
            'beauty-advice' => 'Beauty Advice',
            'feedback' => 'Feedback',
            'other' => 'Other'
        ];

        return $subjects[$this->subject] ?? $this->subject;
    }

    public function scopeLegitimate($query)
    {
        return $query->where('is_bot', false);
    }

    public function scopeBots($query)
    {
        return $query->where('is_bot', true);
    }
}
