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
            $table->integer('user_id')->default(0)->after('id');
            $table->dropColumn('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mix_match', function (Blueprint $table) {
            $table->string('title');
            $table->dropColumn('user_id');
        });
    }
};
