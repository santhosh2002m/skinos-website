<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $defaultCart = json_encode([
            'items' => new stdClass(),
            'totalQty' => 0,
            'totalPrice' => 0,
            'totalDiscount' => 0
        ]);

        DB::table('mix_match')
            ->whereNull('mix_match_cart')
            ->update(['mix_match_cart' => $defaultCart]);
    }

    public function down(): void
    {
        // Optional: Revert to null if needed
        DB::table('mix_match')
            ->where('mix_match_cart', json_encode([
                'items' => new stdClass(),
                'totalQty' => 0,
                'totalPrice' => 0,
                'totalDiscount' => 0
            ]))
            ->update(['mix_match_cart' => null]);
    }
};
