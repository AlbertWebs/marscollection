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
        Schema::table('products', function (Blueprint $table) {
            $table->longText('colors')->nullable()->after('description');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->string('selected_color')->nullable()->after('quantity');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('selected_color')->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('colors');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('selected_color');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('selected_color');
        });
    }
};
