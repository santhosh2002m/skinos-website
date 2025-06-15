<?php

namespace App\Helpers;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Package;
use App\Models\Shipping;
use App\Models\State;
use DB;
use Auth;
use Session;

class PriceHelper
{

    public static function showPrice($price)
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        if (is_numeric($price) && floor($price) != $price) {
            return number_format($price, 2, $gs->decimal_separator, $gs->thousand_separator);
        } else {
            return number_format($price, 0, $gs->decimal_separator, $gs->thousand_separator);
        }
    }

    public static function apishowPrice($price)
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        if (is_numeric($price) && floor($price) != $price) {
            return round($price, 2);
        } else {
            return round($price, 0);
        }
    }

    public static function showCurrencyPrice($price)
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $new_price = 0;
        if (is_numeric($price) && floor($price) != $price) {
            $new_price = number_format($price, 2, $gs->decimal_separator, $gs->thousand_separator);
        } else {
            $new_price = number_format($price, 0, $gs->decimal_separator, $gs->thousand_separator);
        }
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }

        if ($gs->currency_format == 0) {
            return $curr->sign . $new_price;
        } else {
            return $new_price . $curr->sign;
        }
    }

    public static function showAdminCurrencyPrice($price)
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $new_price = 0;
        if (is_numeric($price) && floor($price) != $price) {
            $new_price = number_format($price, 2, $gs->decimal_separator, $gs->thousand_separator);
        } else {
            $new_price = number_format($price, 0, $gs->decimal_separator, $gs->thousand_separator);
        }

        $curr = Currency::where('is_default', '=', 1)->first();

        if ($gs->currency_format == 0) {
            return $curr->sign . $new_price;
        } else {
            return $new_price . $curr->sign;
        }
    }

    public static function showOrderCurrencyPrice($price, $currency)
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $new_price = 0;
        if (is_numeric($price) && floor($price) != $price) {
            $new_price = number_format($price, 2, $gs->decimal_separator, $gs->thousand_separator);
        } else {
            $new_price = number_format($price, 0, $gs->decimal_separator, $gs->thousand_separator);
        }

        if ($gs->currency_format == 0) {
            return $currency . $new_price;
        } else {
            return $new_price . $currency;
        }
    }

    public static function ImageCreateName($image)
    {
        $name = time() . preg_replace('/[^A-Za-z0-9\-]/', '', $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        return $name;
    }

    public static function getOrderTotal($input, $cart)
    {
        try {
            $vendor_ids = [];
            foreach ($cart->items as $item) {
                if (!in_array($item['item']['user_id'], $vendor_ids)) {
                    $vendor_ids[] = $item['item']['user_id'];
                }
            }

            $gs = DB::table('generalsettings')->first();

            $totalAmount = $cart->totalPrice;
            $tax_amount = 0;
            if ($input['tax'] && @$input['tax_type']) {
                if (@$input['tax_type'] == 'state_tax') {
                    $tax = State::findOrFail($input['tax'])->tax;
                } else {
                    $tax = Country::findOrFail($input['tax'])->tax;
                }
                $tax_amount = ($totalAmount / 100) * $tax;
                $totalAmount = $totalAmount + $tax_amount;
            }

            if ($gs->multiple_shipping == 0) {
                $vendor_shipping_ids = [];
                $vendor_packing_ids = [];
                foreach ($vendor_ids as $vendor_id) {
                    $vendor_shipping_ids[$vendor_id] = isset($input['shipping_id']) && $input['shipping_id'] != 0 ? $input['shipping_id'] : null;
                    $vendor_packing_ids[$vendor_id] = isset($input['packaging_id']) && $input['packaging_id'] != 0 ? $input['packaging_id'] : null;
                }

                $shipping = isset($input['shipping_id']) && $input['shipping_id'] != 0 ? Shipping::findOrFail($input['shipping_id']) : null;

                $packeing = isset($input['packaging_id']) && $input['packaging_id'] != 0 ? Package::findOrFail($input['packaging_id']) : null;

                $totalAmount = $totalAmount + @$shipping->price + @$packeing->price;

                if (isset($input['coupon_id']) && !empty($input['coupon_id'])) {
                    $totalAmount = $totalAmount - $input['coupon_discount'];
                }

                if (!empty($input['pay_via_wallet']) && $input['pay_via_wallet'] == "1") {
                    $totalAmount = $totalAmount - Auth::user()->balance;
                }

                return [
                    'total_amount' => $totalAmount,
                    'shipping' => $shipping,
                    'packeing' => $packeing,
                    'is_shipping' => 0,
                    'vendor_shipping_ids' => @json_encode($vendor_shipping_ids),
                    'vendor_packing_ids' => @json_encode($vendor_packing_ids),
                    'vendor_ids' => @json_encode($vendor_ids),
                    'success' => true,
                ];
            } else {

                if (isset($input['shipping']) && gettype($input['shipping']) == 'string') {
                    $shippingData = json_decode($input['shipping'], true);
                } else {
                    $shippingData = isset($input['shipping']) ? $input['shipping'] : null;
                }

                $shipping_cost = 0;
                $packaging_cost = 0;
                $vendor_ids = [];
                if (isset($input['shipping']) && $input['shipping'] != 0 && is_array($shippingData)) {
                    foreach ($shippingData as $key => $shipping_id) {
                        $shipping = Shipping::findOrFail($shipping_id);
                        $shipping_cost += $shipping->price;
                        if (!in_array($shipping->user_id, $vendor_ids)) {
                            $vendor_ids[] = $shipping->user_id;
                        }
                    }
                }

                if (isset($input['packeging']) && gettype($input['packeging']) == 'string') {
                    $packegingData = json_decode($input['packeging'], true);
                } else {
                    $packegingData = isset($input['packeging']) ? $input['packeging'] : null;
                }

                if (isset($input['packeging']) && $input['packeging'] != 0 && is_array($packegingData)) {
                    foreach ($packegingData as $key => $packaging_id) {
                        $packeing = Package::findOrFail($packaging_id);
                        $packaging_cost += $packeing->price;
                        if (!in_array($packeing->user_id, $vendor_ids)) {
                            $vendor_ids[] = $packeing->user_id;
                        }
                    }
                }

                $totalAmount = $totalAmount + $shipping_cost + $packaging_cost;
                if (isset($input['coupon_id']) && !empty($input['coupon_id'])) {
                    $totalAmount = $totalAmount - $input['coupon_discount'];
                }

                if (!empty($input['pay_via_wallet']) && $input['pay_via_wallet'] == "1") {
                    $totalAmount = $totalAmount - Auth::user()->balance;
                }

                return [
                    'total_amount' => $totalAmount,
                    'shipping' => isset($shipping) ? $shipping : null,
                    'packeing' => isset($packeing) ? $packeing : null,
                    'is_shipping' => 1,
                    'tax' => $tax_amount,
                    'vendor_shipping_ids' => @json_encode($input['shipping']),
                    'vendor_packing_ids' => @json_encode($input['packeging']),
                    'vendor_ids' => @json_encode($vendor_ids),
                    'shipping_cost' => $shipping_cost,
                    'packing_cost' => $packaging_cost,
                    'success' => true,
                ];
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function getOrderTotalAmount($input, $cart)
    {

        if (Session::has('currency')) {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return Currency::find(Session::get('currency'));
            });
        } else {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return Currency::where('is_default', '=', 1)->first();
            });
        }

        try {
            $vendor_ids = [];
            foreach ($cart->items as $item) {
                if (!in_array($item['item']['user_id'], $vendor_ids)) {
                    $vendor_ids[] = $item['item']['user_id'];
                }
            }

            $gs = cache()->remember('generalsettings', now()->addDay(), function () {
                return DB::table('generalsettings')->first();
            });
            $totalAmount = $input['total'];

            if ($input['tax'] && @$input['tax_type']) {
                if (@$input['tax_type'] == 'state_tax') {
                    $tax = State::findOrFail($input['tax'])->tax;
                } else {
                    $tax = Country::findOrFail($input['tax'])->tax;
                }
                $tax_amount = ($totalAmount / 100) * $tax;
                $totalAmount = $totalAmount + $tax_amount;
            }

            if ($gs->multiple_shipping == 0) {
                $vendor_shipping_ids = [];
                $vendor_packing_ids = [];
                foreach ($vendor_ids as $vendor_id) {
                    $vendor_shipping_ids[$vendor_id] = $input['shipping_id'];
                    $vendor_packing_ids[$vendor_id] = $input['packaging_id'];
                }

                $shipping = Shipping::findOrFail($input['shipping_id']);
                $packeing = Package::findOrFail($input['packaging_id']);
                $totalAmount = $totalAmount + $shipping->price + $packeing->price;
                return round($totalAmount / $curr->value, 2);
            } else {

                $shipping_cost = 0;
                $packaging_cost = 0;
                $vendor_ids = [];
                if ($input['shipping']) {
                    foreach ($input['shipping'] as $key => $shipping_id) {
                        $shipping = Shipping::findOrFail($shipping_id);
                        $shipping_cost += $shipping->price;
                        if (!in_array($shipping->user_id, $vendor_ids)) {
                            $vendor_ids[] = $shipping->user_id;
                        }
                    }
                }
                if ($input['packeging']) {
                    foreach ($input['packeging'] as $key => $packaging_id) {
                        $packeing = Package::findOrFail($packaging_id);
                        $packaging_cost += $packeing->price;
                        if (!in_array($packeing->user_id, $vendor_ids)) {
                            $vendor_ids[] = $packeing->user_id;
                        }
                    }
                }

                $totalAmount = $totalAmount + $shipping_cost + $packaging_cost;

                return round($totalAmount * $curr->value, 2);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function getMixMatchOrderTotal($input, $cartData)
    {
        try {
            $vendor_ids = [];
            $items = is_array($cartData) ? $cartData['items'] : $cartData->items;
            $totalPrice = is_array($cartData) ? $cartData['totalPrice'] : $cartData->totalPrice;

            foreach ($items as $item) {
                if (is_array($item)) {
                    $userId = $item['item']['user_id'];
                } elseif (is_object($item)) {
                    $userId = $item->item->user_id;
                } else {
                    continue;
                }

                if (!in_array($userId, $vendor_ids)) {
                    $vendor_ids[] = $userId;
                }
            }

            $gs = DB::table('generalsettings')->first();
            $totalAmount = $totalPrice;
            $tax_amount = 0;

            if (!empty($input['tax']) && !empty($input['tax_type'])) {
                if ($input['tax_type'] === 'state_tax') {
                    $tax = State::findOrFail($input['tax'])->tax;
                } else {
                    $tax = Country::findOrFail($input['tax'])->tax;
                }
                $tax_amount = ($totalAmount / 100) * $tax;
                $totalAmount += $tax_amount;
            }

            if ($gs->multiple_shipping == 0) {
                $vendor_shipping_ids = [];
                $vendor_packing_ids = [];

                foreach ($vendor_ids as $vendor_id) {
                    $vendor_shipping_ids[$vendor_id] = $input['shipping_id'] ?? null;
                    $vendor_packing_ids[$vendor_id] = $input['packaging_id'] ?? null;
                }

                $shipping = !empty($input['shipping_id']) ? Shipping::findOrFail($input['shipping_id']) : null;
                $packeing = !empty($input['packaging_id']) ? Package::findOrFail($input['packaging_id']) : null;

                $totalAmount += ($shipping->price ?? 0) + ($packeing->price ?? 0);

                if (!empty($input['coupon_id'])) {
                    $totalAmount -= $input['coupon_discount'];
                }
                if (!empty($input['pay_via_wallet']) && $input['pay_via_wallet'] == "1") {
                    $totalAmount = $totalAmount - Auth::user()->balance;
                }

                return [
                    'total_amount' => $totalAmount,
                    'shipping' => $shipping,
                    'packeing' => $packeing,
                    'is_shipping' => 0,
                    'vendor_shipping_ids' => json_encode($vendor_shipping_ids),
                    'vendor_packing_ids' => json_encode($vendor_packing_ids),
                    'vendor_ids' => json_encode($vendor_ids),
                    'success' => true,
                ];
            } else {
                $shippingData = is_string($input['shipping'] ?? '') ? json_decode($input['shipping'], true) : $input['shipping'] ?? null;
                $packegingData = is_string($input['packeging'] ?? '') ? json_decode($input['packeging'], true) : $input['packeging'] ?? null;

                $shipping_cost = 0;
                $packaging_cost = 0;

                if (!empty($shippingData) && is_array($shippingData)) {
                    foreach ($shippingData as $shipping_id) {
                        $shipping = Shipping::findOrFail($shipping_id);
                        $shipping_cost += $shipping->price;
                        if (!in_array($shipping->user_id, $vendor_ids)) {
                            $vendor_ids[] = $shipping->user_id;
                        }
                    }
                }

                if (!empty($packegingData) && is_array($packegingData)) {
                    foreach ($packegingData as $packaging_id) {
                        $packeing = Package::findOrFail($packaging_id);
                        $packaging_cost += $packeing->price;
                        if (!in_array($packeing->user_id, $vendor_ids)) {
                            $vendor_ids[] = $packeing->user_id;
                        }
                    }
                }

                $totalAmount += $shipping_cost + $packaging_cost;

                if (!empty($input['coupon_id'])) {
                    $totalAmount -= $input['coupon_discount'];
                }

                if (!empty($input['pay_via_wallet']) && $input['pay_via_wallet'] == "1") {
                    $totalAmount = $totalAmount - Auth::user()->balance;
                }

                return [
                    'total_amount' => $totalAmount,
                    'shipping' => $shipping ?? null,
                    'packeing' => $packeing ?? null,
                    'is_shipping' => 1,
                    'tax' => $tax_amount,
                    'vendor_shipping_ids' => json_encode($shippingData),
                    'vendor_packing_ids' => json_encode($packegingData),
                    'vendor_ids' => json_encode($vendor_ids),
                    'shipping_cost' => $shipping_cost,
                    'packing_cost' => $packaging_cost,
                    'success' => true,
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function getMixMatchOrderTotalAmount($input, $cart)
    {
        // Convert input and cart to array if stdClass
        if (is_object($cart)) {
            $cart = json_decode(json_encode($cart), true);
        }

        if (is_object($input)) {
            $input = json_decode(json_encode($input), true);
        }

        if (Session::has('currency')) {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return Currency::find(Session::get('currency'));
            });
        } else {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return Currency::where('is_default', '=', 1)->first();
            });
        }

        // dd($cart);
        try {
            $vendor_ids = [];
            foreach ($cart['items'] as $item) {
                if (!in_array($item['item']['user_id'], $vendor_ids)) {
                    $vendor_ids[] = $item['item']['user_id'];
                }
            }

            $gs = cache()->remember('generalsettings', now()->addDay(), function () {
                return DB::table('generalsettings')->first();
            });

            $totalAmount = $input['total'];

            // Apply tax if applicable
            if (!empty($input['tax']) && !empty($input['tax_type'])) {
                if ($input['tax_type'] === 'state_tax') {
                    $tax = State::findOrFail($input['tax'])->tax;
                } else {
                    $tax = Country::findOrFail($input['tax'])->tax;
                }
                $tax_amount = ($totalAmount / 100) * $tax;
                $totalAmount += $tax_amount;
            }

            // Single shipping mode
            if ($gs->multiple_shipping == 0) {
                $vendor_shipping_ids = [];
                $vendor_packing_ids = [];

                foreach ($vendor_ids as $vendor_id) {
                    $vendor_shipping_ids[$vendor_id] = $input['shipping_id'];
                    $vendor_packing_ids[$vendor_id] = $input['packaging_id'];
                }

                $shipping = Shipping::findOrFail($input['shipping_id']);
                $packaging = Package::findOrFail($input['packaging_id']);

                $totalAmount += $shipping->price + $packaging->price;

                return round($totalAmount / $curr->value, 2);
            }

            // Multiple shipping mode
            $shipping_cost = 0;
            $packaging_cost = 0;
            $vendor_ids = [];

            if (!empty($input['shipping'])) {
                foreach ($input['shipping'] as $shipping_id) {
                    $shipping = Shipping::findOrFail($shipping_id);
                    $shipping_cost += $shipping->price;

                    if (!in_array($shipping->user_id, $vendor_ids)) {
                        $vendor_ids[] = $shipping->user_id;
                    }
                }
            }

            if (!empty($input['packeging'])) {
                foreach ($input['packeging'] as $packaging_id) {
                    $packaging = Package::findOrFail($packaging_id);
                    $packaging_cost += $packaging->price;

                    if (!in_array($packaging->user_id, $vendor_ids)) {
                        $vendor_ids[] = $packaging->user_id;
                    }
                }
            }

            $totalAmount += $shipping_cost + $packaging_cost;

            return round($totalAmount * $curr->value, 2);
        } catch (\Exception $e) {
            // For debugging, you can log this instead of dd() in production
            \Log::error("MixMatchOrder Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
