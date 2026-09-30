<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('traffic_visits', function (Blueprint $table) {
            $table->id();
            $table->char('visitor_key', 64)->index();
            $table->string('path', 191);
            $table->timestamp('visited_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('traffic_visits');
    }
};
