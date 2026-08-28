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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('transaction_code')->unique(); // e.g. PAY-202608-001
            $table->decimal('amount', 14, 2);
            $table->string('payment_type')->default('dp'); // dp, full, pelunasan
            $table->string('payment_method'); // midtrans, qris, virtual_account, bank_transfer, cash
            $table->string('payment_channel')->nullable(); // bca_va, mandiri_va, gopay, qris_shopee
            $table->string('status')->default('pending'); // pending, settlement, success, expire, cancel, refunded
            $table->string('gateway_reference')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
