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
        Schema::table('mix_match', function (Blueprint $table) {
            $table->dropColumn('product_ids');
            $table->longText('mix_match_cart')->after('max_number_of_boxes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mix_match', function (Blueprint $table) {
            $table->dropColumn('mix_match_cart');
            $table->json('product_ids')->after('max_number_of_boxes')->nullable();
        });
    }
};
