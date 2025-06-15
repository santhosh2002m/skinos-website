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
        Schema::table('scheme_entries', function (Blueprint $table) {
            $table->integer('number_of_boxes')->nullable()->after('total_quantity');
            $table->string('name_of_the_box')->after('number_of_boxes');
            $table->integer('quantity_of_items_per_box')->nullable()->after('name_of_the_box');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scheme_entries', function (Blueprint $table) {
            $table->dropColumn(['number_of_boxes', 'name_of_the_box', 'quantity_of_items_per_box']);
        });
    }
};
