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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('service_type'); // e.g., 'bridal_makeup', 'party_makeup', 'photoshoot_makeup'
            $table->text('service_description')->nullable();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->integer('duration')->default(60); // in minutes
            $table->decimal('price', 10, 2);
            $table->text('special_requests')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable(); // for admin notes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
