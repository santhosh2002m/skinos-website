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
        Schema::create('cashbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('min_purchase_value');
            $table->unsignedInteger('max_purchase_value');
            $table->decimal('advance_percentage', 5, 2);
            $table->decimal('days_7_percentage', 5, 2);
            $table->decimal('days_7_30_percentage', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashbacks');
    }
};
