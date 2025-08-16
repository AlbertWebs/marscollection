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
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('bundle_id')->nullable()->constrained()->onDelete('cascade')->after('product_id');
            $table->string('bundle_name')->nullable()->after('bundle_id');
            $table->decimal('bundle_price', 10, 2)->nullable()->after('bundle_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['bundle_id']);
            $table->dropColumn(['bundle_id', 'bundle_name', 'bundle_price']);
        });
    }
};
