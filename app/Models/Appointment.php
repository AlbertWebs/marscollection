<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'service_type',
        'service_description',
        'appointment_date',
        'appointment_time',
        'duration',
        'price',
        'special_requests',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'price' => 'decimal:2',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_type', 'slug');
    }

    public function getFormattedPriceAttribute()
    {
        return 'KES ' . number_format($this->price, 2);
    }

    public function getFormattedDateTimeAttribute()
    {
        return $this->appointment_date->format('M d, Y') . ' at ' . $this->appointment_time->format('g:i A');
    }

    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        
        if ($hours > 0 && $minutes > 0) {
            return $hours . 'h ' . $minutes . 'm';
        } elseif ($hours > 0) {
            return $hours . 'h';
        } else {
            return $minutes . 'm';
        }
    }

    public function getServiceTypeLabelAttribute()
    {
        return $this->service ? $this->service->name : ucfirst(str_replace('_', ' ', $this->service_type));
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'confirmed' => 'green',
            'completed' => 'blue',
            'cancelled' => 'red',
        ];

        return $colors[$this->status] ?? 'gray';
    }
}
