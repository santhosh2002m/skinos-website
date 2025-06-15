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
        Schema::create('scheme_entries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Example: "5+1"
            $table->integer('total_quantity'); // Number of boxes
            $table->string('discount_percentage'); // Details of discount
            $table->integer('max_buying_limit')->default(0); //max limit //0 for unlimited
            $table->boolean('status')->default(true);
            $table->boolean('is_deleted')->default(true);
            $table->foreignId('scheme_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheme_entries');
    }
};
