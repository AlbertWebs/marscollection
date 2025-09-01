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
        Schema::table('reviews', function (Blueprint $table) {
            // Drop existing unique constraints if they exist
            try {
                $table->dropUnique('unique_product_review');
            } catch (Exception $e) {
                // Index might not exist or be in use
            }
            
            try {
                $table->dropUnique('unique_bundle_review');
            } catch (Exception $e) {
                // Index might not exist or be in use
            }
            
            // Add new unique constraints that handle nullable user_id
            $table->unique(['order_id', 'product_id'], 'unique_product_review_per_order');
            $table->unique(['order_id', 'bundle_id'], 'unique_bundle_review_per_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Drop new constraints
            $table->dropUnique('unique_product_review_per_order');
            $table->dropUnique('unique_bundle_review_per_order');
            
            // Restore original constraints
            $table->unique(['order_id', 'user_id', 'product_id'], 'unique_product_review');
            $table->unique(['order_id', 'user_id', 'bundle_id'], 'unique_bundle_review');
        });
    }
};
