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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique(); // e.g. BK-202608-001
            $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('karyawan_id')->nullable()->constrained('users')->nullOnDelete(); // Assigned mechanic
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            
            // Customer Contact (if guest or custom contact)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            
            // Vehicle Details
            $table->string('vehicle_type')->default('mobil'); // motor, mobil
            $table->string('vehicle_brand'); // e.g. Honda, Yamaha, Kawasaki, Toyota, BMW
            $table->string('vehicle_model'); // e.g. Civic Turbo, ZX-25R, XSR 155, GT-R
            $table->string('license_plate'); // e.g. B 1234 ABC
            $table->string('vehicle_year')->nullable();
            $table->string('vehicle_color')->nullable();
            
            // Booking Schedule
            $table->date('booking_date');
            $table->string('booking_time_slot')->default('09:00 WIB');
            
            // Request & Build Information
            $table->text('custom_request')->nullable(); // Keluhan / Permintaan Modifikasi
            $table->text('mechanic_notes')->nullable(); // Catatan pengerjaan dari teknisi
            $table->integer('progress_percentage')->default(0); // 0 - 100%
            
            // Status Workflow: pending -> confirmed -> in_progress -> qc -> completed -> cancelled
            $table->string('status')->default('pending');
            
            // Financial & Payment Gateway
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->decimal('dp_amount', 14, 2)->default(0);
            $table->decimal('paid_amount', 14, 2)->default(0);
            $table->string('payment_status')->default('unpaid'); // unpaid, dp_paid, paid, refunded
            $table->string('payment_method')->nullable(); // midtrans, qris, virtual_account, bank_transfer, cash_workshop
            $table->string('payment_token')->nullable(); // Midtrans Snap token / gateway ref
            $table->string('payment_ref')->nullable(); // External payment transaction reference
            $table->text('payment_payload')->nullable();
            
            // Progress Photos JSON array
            $table->json('progress_photos')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
