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
            $table->string('hcp_clinic_name')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('doctor_qualification')->nullable();
            $table->string('preferred_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['hcp_clinic_name', 'doctor_name', 'doctor_qualification', 'preferred_type']);
        });
    }
};
