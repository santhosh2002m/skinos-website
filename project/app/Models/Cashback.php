<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashback extends Model
{
    use HasFactory;

    protected $table = 'cashbacks';

    protected $fillable = [
        'min_purchase_value',
        'max_purchase_value',
        'advance_percentage',
        'days_7_percentage',
        'days_7_30_percentage',
    ];

    public static function getCashbackPercentage(int $purchaseValue, string $paymentType): ?float
    {
        $cashback = Cashback::where('min_purchase_value', '<=', $purchaseValue)
            ->where('max_purchase_value', '>=', $purchaseValue)
            ->first();

        if (!$cashback) {
            return null;
        }

        return match (strtolower($paymentType)) {
            'advance'     => $cashback->advance_percentage,
            'days_7'      => $cashback->days_7_percentage,
            'days_7_30'   => $cashback->days_7_30_percentage,
            default       => null,
        };
    }
    public static function getAdvanceCashbackPercentage(int $purchaseValue): ?float
    {
        $cashback = Cashback::where('min_purchase_value', '<=', $purchaseValue)
            ->where('max_purchase_value', '>=', $purchaseValue)
            ->first();

        if (!$cashback) {
            return null;
        }

        return $cashback->advance_percentage;
    }
}
