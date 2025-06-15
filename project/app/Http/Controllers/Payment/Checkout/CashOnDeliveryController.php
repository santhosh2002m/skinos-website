<?php

namespace App\Http\Controllers\Payment\Checkout;

use App\Classes\GeniusMailer;
use App\Helpers\OrderHelper;
use App\Helpers\PriceHelper;
use App\Models\Cart;
use App\Models\Cashback;
use App\Models\Country;
use App\Models\Deposit;
use App\Models\MixMatchProduct;
use App\Models\Order;
use App\Models\Reward;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CashOnDeliveryController extends CheckoutBaseControlller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $input = $this->mergeSessionInputs($request->all());

        if ($request->pass_check && !$this->handleAuthentication($input)) {
            return redirect()->back()->with('unsuccess', 'Authentication failed.');
        }

        $isMix = $request->input('is_mixandmatch', false);

        if (!$isMix && !Session::has('cart')) {
            return redirect()->route('front.cart')->with('success', __("You don't have any product to checkout."));
        }

        $cart = $this->getCartData($request, $user);
        OrderHelper::mix_match_license_check($cart);
        $serializedCart = $this->serializeCart($cart);
        $affilateUsers = $this->getAffiliateUsers($cart, $request);

        if ($request->has('is_mixandmatch') && $request->is_mixandmatch == true) {
            $orderCalculate = PriceHelper::getMixMatchOrderTotal($input, $cart);
        } else {
            $orderCalculate = PriceHelper::getOrderTotal($input, $cart);
        }
        if (isset($orderCalculate['success']) && !$orderCalculate['success']) {
            return redirect()->back()->with('unsuccess', $orderCalculate['message']);
        }
        $this->setShippingInfo($input, $orderCalculate);
        // return response()->json($input);
        if ($request->has('is_mixandmatch') && $request->is_mixandmatch == true) {
            $order = $this->createMixMatchOrder($input, $cart, $orderCalculate['total_amount'], $affilateUsers, $request);
        } else {
            $cart = new Cart(Session::get('cart'));
            $order = $this->createOrder($input, $cart, $orderCalculate['total_amount'], $affilateUsers, $request);
        }

        $this->handleCoupon($input);
        if (!empty($input['pay_via_wallet']) && $input['pay_via_wallet'] == "1") {
            $this->createDepositTransaction($input, $order);
        }
        
        
        if (($input['redeem_cb_invoice'] ?? null) != "1") {
            $this->creditWalletWithCashbackTransaction($input, $order, $orderCalculate);
        }else{
            $this->redeemCashbackTransaction($input, $order, $orderCalculate);
        }

        if ($request->has('is_mixandmatch') && $request->is_mixandmatch == true) {
            $this->finalizeMixMatchOrder($order, $cart);
        } else {
            $this->finalizeOrder($order, $cart);
        }

        // $this->sendOrderEmails($order);
        if ($request->has('is_mixandmatch') && $request->is_mixandmatch == true) {
            $this->destroyCart($user);
            return redirect(route('mix_match.payment.return'));
        } else {
            return redirect(route('front.payment.return'));
        }
    }

    private function mergeSessionInputs(array $requestInput): array
    {
        $isMix = $requestInput['is_mixandmatch'] ?? false;

        $step1 = $isMix ? Session::get('mixmatchstep1') : Session::get('step1', []);
        $step2 = $isMix ? Session::get('mixmatchstep2') : Session::get('step2', []);
        return array_merge($step1, $step2, $requestInput);
    }

    private function handleAuthentication(array $input): bool
    {
        $auth = OrderHelper::auth_check($input);
        return $auth['auth_success'] ?? false;
    }

    private function getCartData(Request $request, $user)
    {
        if ($request->has('is_mixandmatch') && $request->is_mixandmatch == true) {
            $rawCart = MixMatchProduct::where('user_id', $user->id)->first();

            if (!$rawCart || !$rawCart->mix_match_cart) {
                throw new \Exception('Cart not found.');
            }

            $cart = json_decode($rawCart->mix_match_cart);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid cart data.');
            }

            return $cart;
        }

        return new Cart(Session::get('cart'));
    }


    private function serializeCart($cart): string
    {
        // If it's a Cart object, access properties directly
        if ($cart instanceof Cart) {
            return json_encode([
                'totalQty' => $cart->totalQty,
                'totalPrice' => $cart->totalPrice,
                'items' => $cart->items,
            ]);
        }

        // If it's an array or stdClass (e.g., from Mix & Match JSON)
        $cartArray = is_array($cart) ? $cart : (array) $cart;

        return json_encode([
            'totalQty' => $cartArray['totalQty'] ?? 0,
            'totalPrice' => $cartArray['totalPrice'] ?? 0,
            'items' => $cartArray['items'] ?? [],
        ]);
    }



    private function getAffiliateUsers($cart, Request $request): ?string
    {
        // Ensure $cart is an object to support ->items access
        if (is_array($cart)) {
            $cart = (object) $cart;
        }

        if ($cart instanceof Cart || is_object($cart)) {
            if ($request->has('is_mixandmatch') && $request->is_mixandmatch == true) {
                $temp = OrderHelper::mix_match_product_affilate_check($cart);
            } else {
                $temp = OrderHelper::product_affilate_check($cart);
            }
            return $temp ? json_encode($temp) : null;
        }

        return null;
    }

    private function setShippingInfo(array &$input, array $orderCalculate): void
    {
        if ($this->gs->multiple_shipping == 0) {
            $shipping = $orderCalculate['shipping'];
            $packeing = $orderCalculate['packeing'];
            $input['shipping_title'] = @$shipping->title;
            $input['vendor_shipping_id'] = @$shipping->id;
            $input['packing_title'] = @$packeing->title;
            $input['vendor_packing_id'] = @$packeing->id;
            $input['shipping_cost'] = @$packeing->price ?? 0;
            $input['packing_cost'] = @$packeing->price ?? 0;
        } else {
            $input['shipping_title'] = $orderCalculate['vendor_shipping_ids'];
            $input['vendor_shipping_id'] = $orderCalculate['vendor_shipping_ids'];
            $input['packing_title'] = $orderCalculate['vendor_packing_ids'];
            $input['vendor_packing_id'] = $orderCalculate['vendor_packing_ids'];
            $input['shipping_cost'] = $orderCalculate['shipping_cost'];
            $input['packing_cost'] = $orderCalculate['packing_cost'];
        }

        $input['is_shipping'] = $orderCalculate['is_shipping'];
        $input['vendor_shipping_ids'] = $orderCalculate['vendor_shipping_ids'];
        $input['vendor_packing_ids'] = $orderCalculate['vendor_packing_ids'];
        $input['vendor_ids'] = $orderCalculate['vendor_ids'];
        unset($input['shipping'], $input['packeging']);
    }

    private function createOrder(array &$input, Cart $cart, float $orderTotal, ?string $affilateUsers, Request $request): Order
    {
        $order = new Order;
        $input['user_id'] = Auth::id();
        $input['cart'] = $this->serializeCart($cart);
        $input['affilate_users'] = $affilateUsers;
        $input['pay_amount'] = $orderTotal;
        $input['order_number'] = Str::random(4) . time();

        if ($request->filled('sales_rep_id')) {
            $order->sales_rep_id = $request->input('sales_rep_id');
            $order->sales_rep_name = $request->input('sales_rep_name');
            $order->sales_rep_email = $request->input('sales_rep_email');
            $order->sales_rep_phone = $request->input('sales_rep_phone');
        }
        
        $cashbackPercentage = Cashback::getCashbackPercentage($orderTotal, "advance");
        $input['cashback_percentage'] = $cashbackPercentage;

        if (($input['redeem_cb_invoice'] ?? null) == "1") {
            $effectiveCashbackPercentage = $cashbackPercentage - 2;
            $input['redeem_cb_in_invoice'] = $effectiveCashbackPercentage;
        }

        if (!empty($input['pay_via_wallet']) && $input['pay_via_wallet'] == "1") {
            $input['wallet_price'] = Auth::user()->balance / $this->curr->value;
        } else {
            $input['wallet_price'] = $request->wallet_price / $this->curr->value;
        }

        $input['tax_location'] = $input['tax_type'] === 'state_tax'
            ? State::findOrFail($input['tax'])->state
            : Country::findOrFail($input['tax'])->country_name;
        $input['tax'] = Session::get('current_tax');

        if (Session::has('affilate')) {
            $this->applyAffiliateDiscount($input, $request);
        }

        $order->fill($input)->save();
        $order->tracks()->create(['title' => 'Pending', 'text' => 'You have successfully placed your order.']);
        $order->notifications()->create();
        return $order;
    }

    private function createMixMatchOrder(array &$input, $decodedCart, float $orderTotal, ?string $affilateUsers, Request $request): Order
    {
        $order = new Order;
        $input['user_id'] = Auth::id();

        // Manually serialize from decoded cart structure
        $input['cart'] = json_encode([
            'totalQty' => $decodedCart->totalQty ?? 0,
            'totalPrice' => $decodedCart->totalPrice ?? 0,
            'items' => $decodedCart->items ?? [],
        ]);

        $input['affilate_users'] = $affilateUsers;
        $input['pay_amount'] = $orderTotal;
        $input['order_number'] = Str::random(4) . time();
        $input['wallet_price'] = $request->wallet_price / $this->curr->value;

        $input['tax_location'] = $input['tax_type'] === 'state_tax'
            ? State::findOrFail($input['tax'])->state
            : Country::findOrFail($input['tax'])->country_name;

        $input['tax'] = Session::get('current_tax');

        if (Session::has('affilate')) {
            $this->applyAffiliateDiscount($input, $request);
        }

        $order->fill($input)->save();
        $order->tracks()->create(['title' => 'Pending', 'text' => 'You have successfully placed your order.']);
        $order->notifications()->create();

        return $order;
    }

    private function applyAffiliateDiscount(array &$input, Request $request): void
    {
        $val = $request->total / $this->curr->value;
        $sub = ($val / 100) * $this->gs->affilate_charge;

        $affUsers = json_decode($input['affilate_users'], true);
        if (is_array($affUsers)) {
            foreach ($affUsers as $t_cost) {
                $sub -= $t_cost['charge'];
            }
        }

        if ($sub > 0) {
            OrderHelper::affilate_check(Session::get('affilate'), $sub, $input['dp']);
            $input['affilate_user'] = Session::get('affilate');
            $input['affilate_charge'] = $sub;
        }
    }

    private function handleCoupon(array $input): void
    {
        if (!empty($input['coupon_id'])) {
            OrderHelper::coupon_check($input['coupon_id']);
        }
    }

    private function handleReward(Order $order): void
    {
        if (!Auth::check() || $this->gs->is_reward != 1) return;

        $rewards = Reward::get();
        $num = $order->pay_amount;
        $closest = null;
        $minDiff = PHP_INT_MAX;

        foreach ($rewards as $reward) {
            $diff = abs($reward->order_amount - $num);
            if ($diff < $minDiff) {
                $minDiff = $diff;
                $closest = $reward;
            }
        }

        if ($closest) {
            Auth::user()->increment('reward', $closest->reward);
        }
    }

    private function finalizeOrder(Order $order, Cart $cart): void
    {
        OrderHelper::size_qty_check($cart);
        OrderHelper::stock_check($cart);
        OrderHelper::vendor_order_check($cart, $order);

        Session::put('temporder', $order);
        Session::put('tempcart', $cart);
        Session::forget(['cart', 'already', 'coupon', 'coupon_total', 'coupon_total1', 'coupon_percentage']);

        // if ($order->user_id && $order->wallet_price > 0) {
        //     OrderHelper::add_to_transaction($order, $order->wallet_price);
        // }
    }
    private function finalizeMixMatchOrder(Order $order, $cart): void
    {
        OrderHelper::size_qty_check_mixmatch($cart);
        OrderHelper::stock_check_mixmatch($cart);
        OrderHelper::vendor_order_check_mixmatch($cart, $order);

        Session::put('temporder', $order);
        Session::put('tempcart', $cart);
        Session::forget([
            'cart',
            'already',
            'coupon',
            'coupon_total',
            'coupon_total1',
            'coupon_percentage'
        ]);

        // if ($order->user_id && $order->wallet_price > 0) {
        //     OrderHelper::add_to_transaction($order, $order->wallet_price);
        // }
    }

    private function sendOrderEmails(Order $order): void
    {
        $data = [
            'to' => $order->customer_email,
            'type' => "new_order",
            'cname' => $order->customer_name,
            'oamount' => "",
            'aname' => "",
            'aemail' => "",
            'wtitle' => "",
            'onumber' => $order->order_number,
        ];

        $mailer = new GeniusMailer();
        $mailer->sendAutoOrderMail($data, $order->id);

        // Admin email (optional)
        $adminData = [
            'to' => $this->ps->contact_email,
            'subject' => "New Order Received!",
            'body' => "Hello Admin!<br>New order placed. Order Number: {$order->order_number}.<br>Check your panel.",
        ];
        $mailer->sendCustomMail($adminData);
    }

    private function destroyCart($user)
    {
        $userCart = MixMatchProduct::where('user_id', $user->id)->first();
        if ($userCart) {
            $userCart->delete();
        }
        session()->forget('mixmatchstep1');
        session()->forget('mixmatchstep2');
    }
    private function createDepositTransaction(array $input, $order)
    {
        if (!isset($input['user_id'])) {
            Log::error('User ID is missing in input', ['input' => $input]);
            throw new \InvalidArgumentException('User ID is required.');
        }

        $sign = $this->curr;

        $user = User::findOrFail($input['user_id']);

        $user->balance -= (float) $order->wallet_price;
        $user->save();

        $deposit = new Deposit();
        $deposit->user_id = $input['user_id'];
        $deposit->deposit_number = Str::random(3) . substr(time(), 6, 8) . Str::random(3);
        $deposit->currency = json_encode([
            'sign' => $sign->sign,
            'name' => $sign->name,
            'value' => $sign->value
        ]);
        $deposit->currency_code = $sign->name;
        $deposit->amount = $order->wallet_price;
        $deposit->currency_value = $sign->value;
        $deposit->method = $order->order_number;
        $deposit->txnid = $order->order_number;
        $deposit->details = "Payment via Wallet";
        $deposit->type = "debit";
        $deposit->flutter_id = null;
        $deposit->status = 1;
        $deposit->save();
    }
    private function creditWalletWithCashbackTransaction(array $input, $order, $orderCalculate)
    {
        if (!isset($input['user_id'])) {
            Log::error('User ID is missing in input', ['input' => $input]);
            throw new \InvalidArgumentException('User ID is required.');
        }
        $cashbackPercentage = Cashback::getCashbackPercentage($orderCalculate['total_amount'], "advance");
        $cashbackAmount = $orderCalculate['total_amount'] * ($cashbackPercentage / 100);
        $sign = $this->curr;

        $user = User::findOrFail($input['user_id']);

        $user->balance += (float) $cashbackAmount ;
        $user->save();

        $deposit = new Deposit();
        $deposit->user_id = $input['user_id'];
        $deposit->deposit_number = Str::random(3) . substr(time(), 6, 8) . Str::random(3);
        $deposit->currency = json_encode([
            'sign' => $sign->sign,
            'name' => $sign->name,
            'value' => $sign->value
        ]);
        $deposit->currency_code = $sign->name;
        $deposit->amount = $cashbackAmount;
        $deposit->currency_value = $sign->value;
        $deposit->method = $order->order_number;
        $deposit->txnid = $order->order_number;
        $deposit->details = "Cashback credited for the Order Number : " . $order['order_number'] ;
        $deposit->type = "credit";
        $deposit->flutter_id = null;
        $deposit->status = 1;
        $deposit->save();
    }
    private function redeemCashbackTransaction(array $input, $order, $orderCalculate)
    {
        if (!isset($input['user_id'])) {
            Log::error('User ID is missing in input', ['input' => $input]);
            throw new \InvalidArgumentException('User ID is required.');
        }
        $cashbackPercentage = Cashback::getCashbackPercentage($orderCalculate['total_amount'], "advance");
        $cashbackAmount = $orderCalculate['total_amount'] * ($cashbackPercentage / 100);
        $sign = $this->curr;

        $deposit = new Deposit();
        $deposit->user_id = $input['user_id'];
        $deposit->deposit_number = Str::random(3) . substr(time(), 6, 8) . Str::random(3);
        $deposit->currency = json_encode([
            'sign' => $sign->sign,
            'name' => $sign->name,
            'value' => $sign->value
        ]);
        $deposit->currency_code = $sign->name;
        $deposit->amount = $cashbackAmount;
        $deposit->currency_value = $sign->value;
        $deposit->method = $order->order_number;
        $deposit->txnid = $order->order_number;
        $deposit->details = "Cashback credited for the Order Number : " . $order['order_number']  . ". Adjusted in the Invoice.";
        $deposit->type = "debit";
        $deposit->flutter_id = null;
        $deposit->status = 1;
        $deposit->save();
    }
}
