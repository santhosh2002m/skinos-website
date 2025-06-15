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
        Schema::create('mix_match', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('scheme_entry_id')->nullable();
            $table->integer('no_of_boxes');
            $table->integer('max_number_of_boxes');
            $table->json('product_ids');
            $table->timestamps();
        
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('scheme_entry_id')->references('id')->on('scheme_entries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mix_match');
    }
};
