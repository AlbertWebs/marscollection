<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Enable pgvector extension (idempotent)
        DB::statement('CREATE EXTENSION IF NOT EXISTS vector');

        // Convert the json column to a native vector(3072) column.
        // We do this in raw SQL because Laravel's Blueprint doesn't know the vector type.
        DB::statement('ALTER TABLE product_embeddings ALTER COLUMN embedding TYPE vector(3072) USING embedding::text::vector');

        // Add an IVFFlat index for approximate nearest-neighbour search (cosine distance).
        // HNSW is limited to 2000 dimensions in pgvector 0.6.x; IVFFlat supports up to 2000 too,
        // but we can use halfvec for the index while keeping the full vector column.
        // For now we use a plain btree-free exact search — at <1000 products this is fast enough.
        // When product count grows past ~10k, add: CREATE INDEX ... USING ivfflat (embedding vector_cosine_ops) WITH (lists = 100)
        // No index created here — sequential scan is fine at current scale.
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE product_embeddings ALTER COLUMN embedding TYPE json USING embedding::text::json');
    }
};
