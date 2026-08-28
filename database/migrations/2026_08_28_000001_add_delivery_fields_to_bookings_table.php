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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('delivery_method')->default('pickup_workshop')->after('status'); // pickup_workshop, delivery_address
            $table->text('delivery_address')->nullable()->after('delivery_method');
            $table->text('delivery_notes')->nullable()->after('delivery_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['delivery_method', 'delivery_address', 'delivery_notes']);
        });
    }
};
