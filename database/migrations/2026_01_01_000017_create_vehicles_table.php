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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type')->default('mobil'); // motor, mobil
            $table->string('brand'); // Honda, Yamaha, Kawasaki, Toyota, BMW, etc.
            $table->string('model'); // Civic Turbo, ZX-25R, etc.
            $table->string('license_plate'); // e.g. B 1234 ABC
            $table->string('year')->nullable();
            $table->string('color')->nullable();
            $table->string('engine_cc')->nullable();
            $table->string('transmission')->nullable(); // manual, matic, dct
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
