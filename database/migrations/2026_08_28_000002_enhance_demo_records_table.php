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
        Schema::table('demo_records', function (Blueprint $table) {
            if (!Schema::hasColumn('demo_records', 'action')) {
                $table->string('action')->default('create')->after('user_id'); // 'create', 'update', 'delete'
            }
            if (!Schema::hasColumn('demo_records', 'original_data')) {
                $table->longText('original_data')->nullable()->after('action');
            }
            if (!Schema::hasColumn('demo_records', 'file_paths')) {
                $table->text('file_paths')->nullable()->after('original_data');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demo_records', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('demo_records', 'action')) $columns[] = 'action';
            if (Schema::hasColumn('demo_records', 'original_data')) $columns[] = 'original_data';
            if (Schema::hasColumn('demo_records', 'file_paths')) $columns[] = 'file_paths';
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
