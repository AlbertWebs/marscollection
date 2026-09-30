<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->string('selected_size')->nullable()->after('selected_color');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('selected_size')->nullable()->after('selected_color');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('selected_size');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('selected_size');
        });
    }
};
