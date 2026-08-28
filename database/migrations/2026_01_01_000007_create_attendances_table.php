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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('date');
            
            // Check-in (Masuk)
            $table->time('check_in_time')->nullable();
            $table->string('check_in_photo')->nullable(); // Saved webcam snapshot path
            $table->decimal('check_in_lat', 10, 8)->nullable();
            $table->decimal('check_in_lng', 11, 8)->nullable();
            
            // Check-out (Pulang)
            $table->time('check_out_time')->nullable();
            $table->string('check_out_photo')->nullable(); // Saved webcam snapshot path
            $table->decimal('check_out_lat', 10, 8)->nullable();
            $table->decimal('check_out_lng', 11, 8)->nullable();
            
            // Attendance Status: hadir, terlambat, izin, sakit, alpa
            $table->string('status')->default('hadir');
            $table->text('work_summary')->nullable(); // Laporan kerja / log pengerjaan hari ini
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Unique per user per date
            $table->unique(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
