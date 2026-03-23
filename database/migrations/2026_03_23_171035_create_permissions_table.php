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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->string('permission');
            $table->string('module_display_name');
            $table->string('permission_display_name');
            $table->timestamps();
        });

        Schema::create("role_permissions", function (Blueprint $table) {
            $table->foreignId('role_id')->unsigned()->nullable()->constrained('roles')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('permission_id')->unsigned()->nullable()->constrained('permissions')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("role_permissions");
        Schema::dropIfExists('permissions');
    }
};
