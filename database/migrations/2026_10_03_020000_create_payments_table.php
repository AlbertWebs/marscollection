<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL can leave the table behind when adding a foreign key fails
        // because an existing production table has a different engine or ID
        // type. Keep this migration safe to retry after that partial DDL.
        if (Schema::hasTable('payments')) {
            return;
        }

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            // Deliberately avoid foreign constraints: live databases may have
            // legacy orders/users ID definitions or non-InnoDB tables. The
            // application detaches order references before deleting orders.
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('reference')->unique();
            $table->string('cart_session_id')->nullable()->index();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('method')->default('mpesa')->index();
            $table->string('provider')->default('manual')->index();
            $table->string('source')->default('storefront')->index();
            $table->decimal('amount', 12, 2);
            $table->char('currency', 3)->default('KES');
            $table->string('status')->default('pending')->index();
            $table->string('provider_request_id')->nullable()->index();
            $table->text('provider_request_url')->nullable();
            $table->string('provider_reference')->nullable()->index();
            $table->text('failure_reason')->nullable();
            $table->text('admin_note')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
