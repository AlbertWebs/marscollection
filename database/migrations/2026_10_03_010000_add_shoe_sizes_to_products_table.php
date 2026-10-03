<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('sizes')->nullable()->after('stock_quantity');
        });

        // Existing active footwear should offer the supported size range after migration.
        DB::table('products')->where('is_active', true)->update([
            'sizes' => json_encode(range(19, 48)),
        ]);
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sizes');
        });
    }
};
