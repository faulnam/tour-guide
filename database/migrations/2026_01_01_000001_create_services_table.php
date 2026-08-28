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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('vehicle_type')->default('both'); // motor, mobil, both
            $table->string('category')->default('modifikasi'); // modifikasi, tuning_dyno, body_paint, kaki_kaki, audio_kelistrikan, servis_berkala
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('base_price', 14, 2)->default(0);
            $table->string('estimated_duration')->nullable(); // e.g. "1-3 Hari"
            $table->string('warranty')->nullable(); // e.g. "Garansi 6 Bulan"
            $table->json('features')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
