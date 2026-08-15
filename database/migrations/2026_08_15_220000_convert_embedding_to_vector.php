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

        // Add an HNSW index for fast approximate nearest-neighbour search (cosine distance)
        DB::statement('CREATE INDEX IF NOT EXISTS product_embeddings_embedding_hnsw
            ON product_embeddings USING hnsw (embedding vector_cosine_ops)');
    }

    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS product_embeddings_embedding_hnsw');
        DB::statement('ALTER TABLE product_embeddings ALTER COLUMN embedding TYPE json USING embedding::text::json');
    }
};
