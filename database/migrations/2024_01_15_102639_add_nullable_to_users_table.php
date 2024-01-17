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
        Schema::table('users', function (Blueprint $table) {
            $table->float('basic_salary')->nullable(true)->change();
            $table->float('ot_rate')->nullable(true)->change();
            $table->float('hourly_rate')->nullable(true)->change();
            $table->foreignId('department_id')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->float('basic_salary')->nullable(false)->change();
            $table->float('ot_rate')->nullable(false)->change();
            $table->float('hourly_rate')->nullable(false)->change();
            $table->foreignId('department_id')->nullable(false)->change();
        });
    }
};
