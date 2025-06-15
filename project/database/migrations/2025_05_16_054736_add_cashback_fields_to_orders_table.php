<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('cashback_percentage', 8, 2)->nullable()->after('vendor_ids');
            $table->decimal('redeem_cb_in_invoice',8, 2)->nullable()->after('cashback_percentage');
            $table->string('credit_pay_time')->nullable()->after('redeem_cb_in_invoice');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['cashback_percentage', 'redeem_cb_in_invoice','credit_pay_time']);
        });
    }
};
