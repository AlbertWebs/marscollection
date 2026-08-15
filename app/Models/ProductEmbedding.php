<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductEmbedding extends Model
{
    protected $fillable = ['product_id', 'embedding', 'model'];

    protected $casts = [
        'embedding' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
