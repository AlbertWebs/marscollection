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
        Schema::create('booking_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('day_of_week'); // 1 (Monday) through 7 (Sunday)
            $table->boolean('is_disabled')->default(false);
            $table->json('disabled_hours')->nullable(); // Array of disabled time slots
            $table->time('business_hours_start')->nullable();
            $table->time('business_hours_end')->nullable();
            $table->integer('slot_duration')->default(60); // in minutes
            $table->time('break_start')->nullable();
            $table->time('break_end')->nullable();
            $table->timestamps();
            
            $table->unique('day_of_week');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_settings');
    }
};
