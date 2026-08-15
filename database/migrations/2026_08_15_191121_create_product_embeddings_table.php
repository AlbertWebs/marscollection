<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_embeddings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->unique()->constrained()->cascadeOnDelete();
            $table->json('embedding'); // float array from Gemini
            $table->string('model')->default('gemini-embedding-004');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_embeddings');
    }
};
