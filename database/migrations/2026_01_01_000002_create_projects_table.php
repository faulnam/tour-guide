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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('vehicle_type')->default('mobil'); // motor, mobil
            $table->string('vehicle_model')->nullable(); // e.g. Nissan GT-R R35
            $table->string('client')->nullable();
            $table->string('location')->nullable();
            $table->string('year')->nullable();
            $table->longText('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('before_image')->nullable();
            $table->string('after_image')->nullable();
            $table->integer('dyno_hp_before')->nullable();
            $table->integer('dyno_hp_after')->nullable();
            $table->integer('dyno_torque_before')->nullable();
            $table->integer('dyno_torque_after')->nullable();
            $table->json('modification_specs')->nullable();
            $table->boolean('is_featured')->default(false); // hero slider & highlights
            $table->boolean('is_recent')->default(false);
            $table->integer('order')->default(0);
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
