<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafficVisit extends Model
{
    public $timestamps = false;

    protected $fillable = ['visitor_key', 'path', 'visited_at'];

    protected $casts = [
        'visited_at' => 'datetime',
    ];
}
