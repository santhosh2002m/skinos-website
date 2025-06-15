<?php

namespace App\Http\Controllers\Payment\Checkout;

use App\{
    Models\Cart,
    Models\Order,
    Models\PaymentGateway,
    Classes\GeniusMailer
};
use App\Helpers\OrderHelper;
use App\Helpers\PriceHelper;
use App\Models\Cashback;
use App\Models\Country;
use App\Models\MixMatchProduct;
use App\Models\Reward;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;
use Illuminate\Support\Str;

class RazorpayController extends CheckoutBaseControlller
{
    public function __construct()
    {
        parent::__construct();
        $data = PaymentGateway::whereKeyword('razorpay')->first();
        $paydata = $data->convertAutoData();
        $this->keyId = $paydata['key'];
        $this->keySecret = $paydata['secret'];
        $this->displayCurrency = 'INR';
        $this->api = new Api($this->keyId, $this->keySecret);
    }


    public function store(Request $request)
    {

        $user = Auth::user();
        $input = $request->all();
        $step1 = $request->is_mixandmatch == true ? Session::get('mixmatchstep1') :Session::get('step1')  ;
        $step2 = $request->is_mixandmatch == true ? Session::get('mixmatchstep2') :Session::get('step2')  ;
        $input = array_merge($step1, $step2, $input);
        $data = PaymentGateway::whereKeyword('razorpay')->first();
        $total = $request->total;

        if($this->curr->name != "INR")
        {
            return redirect()->back()->with('unsuccess',__('Please Select INR Currency For This Payment.'));
        }
        if($request->pass_check) {
            $auth = OrderHelper::auth_check($input); // For Authentication Checking
            if(!$auth['auth_success']){
                return redirect()->back()->with('unsuccess',$auth['error_message']);
            }
        }

        $isMixAndMatch = $request->is_mixandmatch ?? false;

        if (!$isMixAndMatch && !Session::has('cart')) {
            return redirect()->route('front.cart')->with('error', __("You don't have any product to checkout."));
        }

        if ($isMixAndMatch) {
            $user = auth()->user();
            $mixCart = DB::table('user_carts')->where('user_id', $user->id)->value('cart_data');

            if (!$mixCart || json_decode($mixCart) == []) {
                return redirect()->route('user-mix_match_cart')->with('error', __("You don't have any product to checkout."));
            }
        }

        $rawCart = MixMatchProduct::where('user_id', $user->id)->get();
        if (!$rawCart) {
            return redirect()->route('user-mix_match_cart')->with('error', __("Cart not initiated."));
        }
        if (($request->is_mixandmatch == true && $rawCart->isNotEmpty())) {
            $cart = json_decode($rawCart[0]->mix_match_cart);
        }
        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->route('user-mix_match_cart')->with('error', __("Invalid Cart."));
        }

        $order['item_name'] = $this->gs->title." Order";
        $order['item_number'] = Str::random(4).time();
        $order['item_amount'] = (int) round($total * 100);
        $cancel_url = route('front.payment.cancle');
        $notify_url = route('front.razorpay.notify');

        if ($request->is_mixandmatch == true) {
            $total = PriceHelper::getMixMatchOrderTotalAmount($input, $cart);
        }else{
            $total = PriceHelper::getOrderTotalAmount($input, Session::get('cart'));
        }
        if (!empty($input['pay_via_wallet']) && $input['pay_via_wallet'] == "1") {
            $total = $total - Auth::user()->balance;
        }
        
        $cashbackPercentage = Cashback::getCashbackPercentage($total, "advance");
        $input['cashback_percentage'] = $cashbackPercentage;
        
        if (($input['redeem_cb_invoice'] ?? null) == "1") {
            $effectiveCashbackPercentage = $cashbackPercentage - 2;
            $total = $total - ($total * $effectiveCashbackPercentage/100);
        }
        //? TODO : save all the cashback variable s in the sessions and retrive in the notify

        $orderData = [
            'receipt'         => $order['item_number'],
            'amount'          => (int) round($total * 100), // 2000 rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        $razorpayOrder = $this->api->order->create($orderData);

        Session::put('input_data',$input);
        Session::put('order_data',$order);
        Session::put('order_payment_id', $razorpayOrder['id']);

        $displayAmount = $amount = $orderData['amount'];

        if ($this->displayCurrency !== 'INR')
        {
            $url = "https://api.fixer.io/latest?symbols=$this->displayCurrency&base=INR";
            $exchange = json_decode(file_get_contents($url), true);

            $displayAmount = $exchange['rates'][$this->displayCurrency] * $amount / 100;
        }

        $checkout = 'automatic';

        if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
        {
            $checkout = $_GET['checkout'];
        }

        $data = [
            "key"               => $this->keyId,
            "amount"            => $amount,
            "name"              => $order['item_name'],
            "description"       => $order['item_name'],
            "prefill"           => [
                "name"              => $request->customer_name,
                "email"             => $request->customer_email,
                "contact"           => $request->customer_phone,
            ],
            "notes"             => [
                "address"           => $request->customer_address,
                "merchant_order_id" => $order['item_number'],
            ],
            "theme"             => [
                "color"             => "{{$this->gs->colors}}"
            ],
            "order_id"          => $razorpayOrder['id'],
        ];

        if ($this->displayCurrency !== 'INR')
        {
            $data['display_currency']  = $this->displayCurrency;
            $data['display_amount']    = $displayAmount;
        }

        $json = json_encode($data);
        $displayCurrency = $this->displayCurrency;


        view()->share('langg', $this->language);
        return view( 'frontend.razorpay-checkout', compact( 'data','displayCurrency','json','notify_url' ) );
    }

    public function notify(Request $request)
    {
        $inputData = $request->all();

        if (!$this->verifySignature($inputData)) {
            return redirect(route('front.payment.cancle'));
        }

        $input = Session::get('input_data');
        $orderData = Session::get('order_data');
        $cart = new Cart(Session::get('cart'));

        $this->handleLicenseAndAffiliate($cart);

        $orderCalculation = PriceHelper::getOrderTotal($input, $cart);
        if (isset($orderCalculation['success']) && !$orderCalculation['success']) {
            return redirect()->back()->with('unsuccess', $orderCalculation['message']);
        }

        $this->populateShippingDetails($input, $orderCalculation);
        $order = $this->createOrder($input, $orderData, $inputData, $cart);

        $this->finalizeOrder($order, $cart);
        // $this->sendOrderEmails($order);

        return redirect(route('front.payment.return'));
    }

    private function verifySignature($inputData)
    {
        $paymentId = Session::get('order_payment_id');
        if (empty($inputData['razorpay_payment_id'])) {
            return false;
        }

        try {
            $attributes = [
                'razorpay_order_id' => $paymentId,
                'razorpay_payment_id' => $inputData['razorpay_payment_id'],
                'razorpay_signature' => $inputData['razorpay_signature']
            ];
            $this->api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (SignatureVerificationError $e) {
            return false;
        }
    }

    private function handleLicenseAndAffiliate($cart)
    {
        OrderHelper::license_check($cart);
        OrderHelper::product_affilate_check($cart);
    }

    private function populateShippingDetails(&$input, $orderCalculation)
    {
        if ($this->gs->multiple_shipping == 0) {
            $this->assignSingleShipping($input, $orderCalculation);
        } else {
            $this->assignMultipleShipping($input, $orderCalculation);
        }
    }

    private function assignSingleShipping(&$input, $calc)
    {
        $input['shipping_title'] = @$calc['shipping']->title;
        $input['vendor_shipping_id'] = @$calc['shipping']->id;
        $input['packing_title'] = @$calc['packeing']->title;
        $input['vendor_packing_id'] = @$calc['packeing']->id;
        $input['shipping_cost'] = @$calc['packeing']->price ?? 0;
        $input['packing_cost'] = @$calc['packeing']->price ?? 0;
        $input['is_shipping'] = $calc['is_shipping'];
        $input['vendor_shipping_ids'] = $calc['vendor_shipping_ids'];
        $input['vendor_packing_ids'] = $calc['vendor_packing_ids'];
        $input['vendor_ids'] = $calc['vendor_ids'];
    }

    private function assignMultipleShipping(&$input, $calc)
    {
        $input['shipping_title'] = $calc['vendor_shipping_ids'];
        $input['vendor_shipping_id'] = $calc['vendor_shipping_ids'];
        $input['packing_title'] = $calc['vendor_packing_ids'];
        $input['vendor_packing_id'] = $calc['vendor_packing_ids'];
        $input['shipping_cost'] = $calc['shipping_cost'];
        $input['packing_cost'] = $calc['packing_cost'];
        $input['is_shipping'] = $calc['is_shipping'];
        $input['vendor_shipping_ids'] = $calc['vendor_shipping_ids'];
        $input['vendor_packing_ids'] = $calc['vendor_packing_ids'];
        $input['vendor_ids'] = $calc['vendor_ids'];
        unset($input['shipping'], $input['packeging']);
    }

    private function createOrder(&$input, $orderData, $inputData, $cart)
    {
        $order = new Order;

        $input['cart'] = json_encode([
            'totalQty' => $cart->totalQty,
            'totalPrice' => $cart->totalPrice,
            'items' => $cart->items
        ]);

        $input['user_id'] = Auth::check() ? Auth::id() : null;
        $input['order_number'] = $orderData['item_number'];
        $input['wallet_price'] = $input['wallet_price'] / $this->curr->value;
        $input['payment_status'] = "Completed";
        $input['txnid'] = $inputData['razorpay_payment_id'];
        $input['tax_location'] = $this->getTaxLocation($input);
        $input['tax'] = Session::get('current_tax');
        $input['pay_amount'] = PriceHelper::getOrderTotal($input, $cart)['total_amount'];

        if ($input['dp'] == 1) {
            $input['status'] = 'completed';
        }

        if (Session::has('affilate')) {
            $this->processAffiliate($input, $cart);
        }

        $order->fill($input)->save();
        $order->tracks()->create(['title' => 'Pending', 'text' => 'You have successfully placed your order.']);
        $order->notifications()->create();

        if (!empty($input['coupon_id'])) {
            OrderHelper::coupon_check($input['coupon_id']);
        }

        return $order;
    }

    private function getTaxLocation($input)
    {
        return $input['tax_type'] === 'state_tax'
            ? State::findOrFail($input['tax'])->state
            : Country::findOrFail($input['tax'])->country_name;
    }

    private function processAffiliate(&$input, $cart)
    {
        $val = request()->total / $this->curr->value;
        $val = $val / 100;
        $sub = $val * $this->gs->affilate_charge;

        $tempAffiliateUsers = OrderHelper::product_affilate_check($cart);
        if ($tempAffiliateUsers) {
            $t_sub = array_sum(array_column($tempAffiliateUsers, 'charge'));
            $sub -= $t_sub;
        }

        if ($sub > 0) {
            OrderHelper::affilate_check(Session::get('affilate'), $sub, $input['dp']);
            $input['affilate_user'] = Session::get('affilate');
            $input['affilate_charge'] = $sub;
        }
    }

    private function finalizeOrder($order, $cart)
    {
        OrderHelper::size_qty_check($cart);
        OrderHelper::stock_check($cart);
        OrderHelper::vendor_order_check($cart, $order);

        Session::put('temporder', $order);
        Session::put('tempcart', $cart);
        Session::forget(['cart', 'already', 'coupon', 'coupon_total', 'coupon_total1', 'coupon_percentage']);

        // if ($order->user_id && $order->wallet_price) {
        //     OrderHelper::add_to_transaction($order, $order->wallet_price);
        // }

        // if (Auth::check() && $this->gs->is_reward == 1) {
        //     $this->rewardUser(Auth::user(), $order->pay_amount);
        // }
    }

    private function rewardUser($user, $amount)
    {
        $rewards = Reward::all();
        $closest = null;
        foreach ($rewards as $reward) {
            if (!$closest || abs($reward->order_amount - $amount) < abs($closest->order_amount - $amount)) {
                $closest = $reward;
            }
        }

        if ($closest) {
            $user->increment('reward', $closest->reward);
        }
    }

    private function sendOrderEmails($order)
    {
        $buyerData = [
            'to' => $order->customer_email,
            'type' => "new_order",
            'cname' => $order->customer_name,
            'oamount' => "",
            'aname' => "",
            'aemail' => "",
            'wtitle' => "",
            'onumber' => $order->order_number,
        ];
        (new GeniusMailer())->sendAutoOrderMail($buyerData, $order->id);

        $adminData = [
            'to' => $this->ps->contact_email,
            'subject' => "New Order Recieved!!",
            'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is " . $order->order_number . ". Please login to your panel to check. <br>Thank you.",
        ];
        (new GeniusMailer())->sendCustomMail($adminData);
    }


}
