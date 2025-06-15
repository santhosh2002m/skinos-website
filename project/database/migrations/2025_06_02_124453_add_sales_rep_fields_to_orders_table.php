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
        Schema::table('orders', function (Blueprint $table) {
            Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_rep_id')->nullable()->after('credit_pay_time');
            $table->string('sales_rep_name')->nullable()->after('sales_rep_id');
            $table->string('sales_rep_email')->nullable()->after('sales_rep_name');
            $table->string('sales_rep_phone')->nullable()->after('sales_rep_email');
        });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'sales_rep_id',
                'sales_rep_name',
                'sales_rep_email',
                'sales_rep_phone',
            ]);
        });
    }
};
