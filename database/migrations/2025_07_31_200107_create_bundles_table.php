<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->string('image');
            $table->string('badge')->nullable();
            $table->string('badge_color')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->integer('sold_count')->default(0);
            $table->decimal('rating', 2, 1)->default(4.5);
            $table->integer('review_count')->default(0);
            $table->string('category');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundles');
    }
};
