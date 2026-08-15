<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProductEmbedding extends Model
{
    protected $fillable = ['product_id', 'embedding', 'model'];

    // pgvector stores/returns the vector as a string like "[0.1,0.2,...]"
    // We cast to array for PHP use and encode back to string for DB writes.
    protected $casts = [
        'embedding' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope: order by cosine similarity to a given vector (closest first).
     * Uses pgvector's <=> operator (cosine distance, lower = more similar).
     *
     * @param Builder $query
     * @param array   $vector  float[] from Gemini
     * @param int     $limit
     */
    public function scopeNearestTo(Builder $query, array $vector, int $limit = 10): Builder
    {
        $pgVector = '[' . implode(',', $vector) . ']';

        return $query
            ->selectRaw('*, (embedding <=> ?::vector) AS distance', [$pgVector])
            ->orderBy('distance')
            ->limit($limit);
    }
}
