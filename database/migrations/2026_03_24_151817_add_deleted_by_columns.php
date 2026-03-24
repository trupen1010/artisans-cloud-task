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
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete()->after('updated_by');
        });

        Schema::table('parents', function (Blueprint $table) {
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete()->after('updated_by');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete()->after('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['deleted_by_id']);
            $table->dropColumn(['deleted_by']);
        });

        Schema::table('parents', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['deleted_by_id']);
            $table->dropColumn(['deleted_by']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['deleted_by_id']);
            $table->dropColumn(['deleted_by']);
        });
    }
};
