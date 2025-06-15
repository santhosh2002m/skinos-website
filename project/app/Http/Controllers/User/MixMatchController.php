<?php

namespace App\Http\Controllers\User;

use App\Helpers\PriceHelper;
use App\Http\Controllers\Front\FrontBaseController;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Cashback;
use App\Models\MixMatchProduct;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\Product;
use App\Models\SchemeEntries;
use Datatables;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MixMatchController extends FrontBaseController
{
    public function index()
    {
        $brands = Brand::where('status', 1)->with([
            'scheme',
            'scheme.scheme_entries' => function ($query) {
                $query->orderBy('order');
            },
        ])->get();

        return view('user.mixmatch.index', compact('brands'));
    }

    public function datatables(Request   $request)
    {
        $datas = Product::where('status', 1);
        if ($request->filled('brand_id')) {
            $datas->where('brand_id', $request->brand_id);
        }
        $datas->select([
            'id',
            'user_id',
            'slug',
            'sku',
            'name',
            'photo',
            'thumbnail',
            'size',
            'size_qty',
            'size_price',
            'color',
            'price',
            'stock',
            'type',
            'file',
            'link',
            'license',
            'license_qty',
            'measure',
            'whole_sell_qty',
            'whole_sell_discount',
            'attributes',
            'color_all',
            "color_price"
        ]);

        return DataTables::of($datas)
            ->editColumn('product', function (Product $data) {
                $price = PriceHelper::showCurrencyPrice($data->price);
                $img = '<img src="' . asset('assets/images/thumbnails/' . $data->thumbnail) . '" alt="' . $data->name . '" class="img-thumbnail mb-2" width="100">';
                $name = mb_strlen($data->name, 'UTF-8') > 50 ? mb_substr($data->name, 0, 50, 'UTF-8') . '...' : $data->name;
                $productJson = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');

                return <<<HTML
                    <div class="product-card text-left d-flex gap-3">
                        <div class="image-container">
                            {$img}
                        </div>
                        <div class="content-container">
                            <strong class="d-block mb-1">{$name}</strong>
                            <small class="d-block mb-2">Price: <strong style="font-size:1.2rem">{$price}</strong></small>
                            <button class="btn btn-sm btn-secondary add-to-box" 
                                data-image="/assets/images/thumbnails/{$data->thumbnail}" 
                                data-name="{$data->name}" 
                                data-sku="{$data->sku}" 
                                data-product="{$productJson}">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>
                    </div>
                HTML;
            })
            ->rawColumns(['product'])
            ->toJson();
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'scheme_id' => 'required|integer|exists:scheme_entries,id',
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:products,id',
        ]);

        $schemeEntry = SchemeEntries::find($validated['scheme_id']);
        $cart = new \stdClass();
        $cart->items = [];
        $cart->totalQty = 0;
        $cart->totalPrice = 0;
        $cart->totalDiscount = 0;

        foreach ($request['items'] as $itemData) {
            $product = Product::find($itemData['id']);
            if (!$product) continue;

            $basePrice = $product->price;
            $discount = $schemeEntry->discount_percentage ?? 0;
            $finalPricePerItem = $basePrice - ($basePrice * $discount / 100);
            $totalPriceForQty = $finalPricePerItem * $schemeEntry->quantity_of_items_per_box;

            $uniqueKey = $itemData['uid'];

            $storedItem = [
                'user_id'       => $product->user_id,
                'qty'           => $schemeEntry->quantity_of_items_per_box,
                'size_key'      => $sizeIndex ?? 0,
                'size_qty'      => $sizeQty ?? 0,
                'size_price'    => $sizePrice ?? 0,
                'size'          => $itemData['size'] ?? '',
                'color'         => $itemData['color'] ?? '',
                'stock'         => $product->stock,
                'price'         => $totalPriceForQty,
                'item'          => $product,
                'license'       => '',
                'dp'            => $product->type !== 'Physical' ? 1 : 0,
                'keys'          => $itemData['keys'] ?? '',
                'values'        => $itemData['values'] ?? '',
                'item_price'    => $basePrice,
                'discount'      => $discount,
                'affilate_user' => 0,
                'scheme'        => $schemeEntry
            ];

            $cart->items[$uniqueKey] = $storedItem;
            $cart->totalQty++;
            $cart->totalPrice += $totalPriceForQty;
            $cart->totalDiscount += ($basePrice * $schemeEntry->quantity_of_items_per_box) - $totalPriceForQty;
        }

        $mixMatchEntry = MixMatchProduct::updateOrCreate(
            [
                'user_id' =>  $user->id,
            ],
            [
                'no_of_boxes' => $schemeEntry->number_of_boxes,
                'max_number_of_boxes' => $schemeEntry->number_of_boxes,
                'mix_match_cart' => json_encode($cart),
                'scheme_entry_id' => $schemeEntry->id,
                'brand_id' => $request['brand_id'],
            ]
        );


        return response()->json([
            'success' => true,
            'data' => $mixMatchEntry,
            'cart' => $cart
        ]);
    }
    public function loadcart()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('user-mix_match');
        }
        $rawCart = MixMatchProduct::where('user_id', $user->id)->get();
        if (!$rawCart) {
            $cart = json_decode('{"items":{},"totalQty":0,"totalPrice":0,"totalDiscount":0}');
        }
        if ($rawCart) {
            $cart = json_decode($rawCart[0]->mix_match_cart);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $cart = json_decode('{"items":{},"totalQty":0,"totalPrice":0,"totalDiscount":0}');
            }
        }
        $products = $cart->items;
        $totalPrice = $cart->totalPrice;
        $totalQty = $cart->totalQty;
        $mainTotal = $totalPrice;
        // return $cart;
        return view('frontend.ajax.cart-page-mixandmatch', compact('products', 'totalPrice', 'mainTotal', 'totalQty'));
    }
    public function checkout()
    {
        $cart = null;

        if (Auth::check()) {
            $userCart = MixMatchProduct::where('user_id', Auth::id())->first();
            if ($userCart && $userCart->mix_match_cart) {
                $cart = json_decode($userCart->mix_match_cart);
            }
        }

        if ($cart === null) {
            return redirect()->route('front.cart')->with('success', __("You don't have any product to checkout."));
        }

        $dp = 1;
        $vendor_shipping_id = 0;
        $vendor_packing_id = 0;
        $curr = $this->curr;
        $pickups = DB::table('pickups')->get();
        $products = $cart->items;

        // COMMON SHIPPING AND PACKAGING LOGIC
        $getShippingAndPackagingData = function () use (&$vendor_shipping_id, &$vendor_packing_id, $cart) {
            if ($this->gs->multiple_shipping == 1) {
                $ship_data = Order::getMixMatchShipData($cart);
                $shipping_data = $ship_data['shipping_data'];
                $vendor_shipping_id = $ship_data['vendor_shipping_id'];
            } else {
                $shipping_data = DB::table('shippings')->whereUserId(0)->get();
            }

            if ($this->gs->multiple_shipping == 1 || $this->gs->multiple_packaging == 1) {
                $pack_data = Order::getMixMatchPackingData($cart);
                $package_data = $pack_data['package_data'];
                $vendor_packing_id = $pack_data['vendor_packing_id'];
            } else {
                $package_data = DB::table('packages')->whereUserId(0)->get();
            }

            return [$shipping_data, $package_data];
        };

        // Detect if cart has physical product
        foreach ($products as $prod) {
            if ($prod->item->type == 'Physical') {
                $dp = 0;
                break;
            }
        }

        $total = $cart->totalPrice;
        $coupon = Session::has('coupon') ? Session::get('coupon') : 0;

        if (!Session::has('coupon_total')) {
            $total -= $coupon;
        } else {
            $total = Session::get('coupon_total');
            $total = is_numeric($total) ? $total : str_replace(',', '', str_replace($curr->sign, '', $total));
        }
        // Authenticated user checkout
        if (Auth::check()) {
            [$shipping_data, $package_data] = $getShippingAndPackagingData();

            // dd($cart);
            return view('frontend.mixmatchcheckout.step1', [
                'products' => $cart->items,
                'totalDiscount' => $cart->totalDiscount,
                'totalPrice' => $total,
                'pickups' => $pickups,
                'totalQty' => $cart->totalQty,
                'shipping_cost' => 0,
                'digital' => $dp,
                'curr' => $curr,
                'shipping_data' => $shipping_data,
                'package_data' => $package_data,
                'vendor_shipping_id' => $vendor_shipping_id,
                'vendor_packing_id' => $vendor_packing_id,
            ]);
        }

        // Guest checkout logic
        if ($this->gs->guest_checkout == 1) {
            [$shipping_data, $package_data] = $getShippingAndPackagingData();

            foreach ($products as $prod) {
                if ($prod->item->type != 'Physical') {
                    return view('frontend.mixmatchcheckout.step1', [
                        'products' => $cart->items,
                        'totalPrice' => $total,
                        'pickups' => $pickups,
                        'totalQty' => $cart->totalQty,
                        'shipping_cost' => 0,
                        'digital' => $dp,
                        'curr' => $curr,
                        'shipping_data' => $shipping_data,
                        'package_data' => $package_data,
                        'vendor_shipping_id' => $vendor_shipping_id,
                        'vendor_packing_id' => $vendor_packing_id,
                    ]);
                }
            }

            return view('frontend.mixmatchcheckout.step1', [
                'products' => $cart->items,
                'totalPrice' => $total,
                'pickups' => $pickups,
                'totalQty' => $cart->totalQty,
                'shipping_cost' => 0,
                'digital' => $dp,
                'curr' => $curr,
                'shipping_data' => $shipping_data,
                'package_data' => $package_data,
                'vendor_shipping_id' => $vendor_shipping_id,
                'vendor_packing_id' => $vendor_packing_id,
            ]);
        }

        // If guest checkout is disabled
        [$shipping_data, $package_data] = $getShippingAndPackagingData();

        return view('frontend.mixmatchcheckout.step1', [
            'products' => $cart->items,
            'totalPrice' => $total,
            'pickups' => $pickups,
            'totalQty' => $cart->totalQty,
            'shipping_cost' => 0,
            'digital' => $dp,
            'curr' => $curr,
            'shipping_data' => $shipping_data,
            'package_data' => $package_data,
            'vendor_shipping_id' => $vendor_shipping_id,
            'vendor_packing_id' => $vendor_packing_id,
        ]);
    }
    public function checkoutStep1(Request $request)
    {
        $step1 = $request->all();
        $step2 = array_merge($step1, [
            "shipping" => ["1"],
            "packeging" => ["1"]
        ]);
        // Change from STEP 2 to STEP 1
        Session::put('mixmatchstep1', $step1);
        Session::put('mixmatchstep2', $step2);
        return redirect()->route('user-mix_match_checkout.step2');
    }
    public function checkoutstep3()
    {
        $user = Auth::user();
        if (!Session::has('mixmatchstep1')) {
            return redirect()->route('front.checkout')->with('success', __("Please fill up step 1."));
        }
        if (!Session::has('mixmatchstep2')) {
            return redirect()->route('front.checkout.step2')->with('success', __("Please fill up step 2."));
        }

        $rawCart = MixMatchProduct::where('user_id', $user->id)->get();
        if (!$rawCart) {
            return response()->json(['message' => 'Cart not found.'], 404);
        }

        $step1 = (object) Session::get('mixmatchstep1');
        $step2 = (object) Session::get('mixmatchstep2');

        $cart = json_decode($rawCart[0]->mix_match_cart);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['message' => 'Invalid cart data.'], 400);
        }

        $dp = 1;
        $vendor_shipping_id = 0;
        $vendor_packing_id = 0;
        $curr = $this->curr;
        $gateways = PaymentGateway::scopeHasGateway($this->curr->id);
        $pickups = DB::table('pickups')->get();
        $products = $cart->items;
        $paystack = PaymentGateway::whereKeyword('paystack')->first();
        $paystackData = $paystack->convertAutoData();

        $cashbacks = Cashback::all();

        if (Auth::check()) {

            // Shipping Method

            if ($this->gs->multiple_shipping == 1) {
                $ship_data = Order::getMixMatchShipData($cart);
                $shipping_data = $ship_data['shipping_data'];
                $vendor_shipping_id = $ship_data['vendor_shipping_id'];
            } else {
                $shipping_data = DB::table('shippings')->whereUserId(0)->get();
            }

            // Packaging

            if ($this->gs->multiple_shipping == 1) {
                $pack_data = Order::getMixMatchPackingData($cart);
                $package_data = $pack_data['package_data'];
                $vendor_packing_id = $pack_data['vendor_packing_id'];
            } else {
                $package_data = DB::table('packages')->whereUserId(0)->get();
            }
            foreach ($products as $prod) {
                $item = is_array($prod) ? $prod['item'] : $prod->item;
                $type = is_array($item) ? $item['type'] : $item->type;

                if ($type == 'Physical') {
                    $dp = 0;
                    break;
                }
            }

            $total = $cart->totalPrice;
            $coupon = Session::has('coupon') ? Session::get('coupon') : 0;

            if (!Session::has('coupon_total')) {
                $total = $total - $coupon;
                $total = $total + 0;
            } else {
                $total = Session::get('coupon_total');
                $total = str_replace(',', '', str_replace($curr->sign, '', $total));
            }

            $cashback_percentage = Cashback::getAdvanceCashbackPercentage($total);

            return view('frontend.mixmatchcheckout.step3', ['products' => $cart->items, 'totalDiscount' => $cart->totalDiscount, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'digital' => $dp, 'curr' => $curr, 'shipping_data' => $shipping_data, 'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id, 'paystack' => $paystackData, 'step1' => $step1, 'step2' => $step2, 'cashbacks' => $cashbacks, 'cashback_percentage' => $cashback_percentage]);
        } else {

            if ($this->gs->guest_checkout == 1) {
                if ($this->gs->multiple_shipping == 1) {
                    $ship_data = Order::getMixMatchShipData($cart);
                    $shipping_data = $ship_data['shipping_data'];
                    $vendor_shipping_id = $ship_data['vendor_shipping_id'];
                } else {
                    $shipping_data = DB::table('shippings')->where('user_id', '=', 0)->get();
                }

                // Packaging

                if ($this->gs->multiple_shipping == 1) {
                    $pack_data = Order::getMixMatchPackingData($cart);
                    $package_data = $pack_data['package_data'];
                    $vendor_packing_id = $pack_data['vendor_packing_id'];
                } else {
                    $package_data = DB::table('packages')->whereUserId('0')->get();
                }

                foreach ($products as $prod) {
                    $item = is_array($prod) ? $prod['item'] : $prod->item;
                    $type = is_array($item) ? $item['type'] : $item->type;

                    if ($type == 'Physical') {
                        $dp = 0;
                        break;
                    }
                }

                $total = $cart->totalPrice;
                $coupon = Session::has('coupon') ? Session::get('coupon') : 0;

                if (!Session::has('coupon_total')) {
                    $total = $total - $coupon;
                    $total = $total + 0;
                } else {
                    $total = Session::get('coupon_total');
                    $total = str_replace($curr->sign, '', $total) + round(0 * $curr->value, 2);
                }
                $cashback_percentage = Cashback::getAdvanceCashbackPercentage($total);
                foreach ($products as $prod) {
                    $item = is_array($prod) ? $prod['item'] : $prod->item;
                    $type = is_array($item) ? $item['type'] : $item->type;

                    if ($type != 'Physical') {
                        if (!Auth::check()) {
                            $ck = 1;
                            return view('frontend.mixmatchcheckout.step3', [
                                'products' => $cart->items,
                                'totalPrice' => $total,
                                'pickups' => $pickups,
                                'totalQty' => $cart->totalQty,
                                'gateways' => $gateways,
                                'shipping_cost' => 0,
                                'digital' => $dp,
                                'curr' => $curr,
                                'shipping_data' => $shipping_data,
                                'package_data' => $package_data,
                                'vendor_shipping_id' => $vendor_shipping_id,
                                'vendor_packing_id' => $vendor_packing_id,
                                'paystack' => $paystackData,
                                'step2' => $step2,
                                'step1' => $step1,
                                'cashbacks' => $cashbacks,
                                'cashback_percentage' => $cashback_percentage
                            ]);
                        }
                    }
                }

                return view('frontend.mixmatchcheckout.step3', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'digital' => $dp, 'curr' => $curr, 'shipping_data' => $shipping_data, 'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id, 'paystack' => $paystackData, 'step2' => $step2, 'step1' => $step1, 'cashbacks' => $cashbacks, 'cashback_percentage' => $cashback_percentage]);
            }

            // If guest checkout is Deactivated then display pop up form with proper error message

            else {

                // Shipping Method

                if ($this->gs->multiple_shipping == 1) {
                    $ship_data = Order::getMixMatchShipData($cart);
                    $shipping_data = $ship_data['shipping_data'];
                    $vendor_shipping_id = $ship_data['vendor_shipping_id'];
                } else {
                    $shipping_data = DB::table('shippings')->where('user_id', '=', 0)->get();
                }

                // Packaging

                if ($this->gs->multiple_packaging == 1) {
                    $pack_data = Order::getMixMatchPackingData($cart);
                    $package_data = $pack_data['package_data'];
                    $vendor_packing_id = $pack_data['vendor_packing_id'];
                } else {
                    $package_data = DB::table('packages')->where('user_id', '=', 0)->get();
                }

                $total = $cart->totalPrice;
                $coupon = Session::has('coupon') ? Session::get('coupon') : 0;

                if (!Session::has('coupon_total')) {
                    $total = $total - $coupon;
                    $total = $total + 0;
                } else {
                    $total = Session::get('coupon_total');
                    $total = $total;
                }
                $cashback_percentage = Cashback::getAdvanceCashbackPercentage($total);
                $ck = 1;
                return view('frontend.mixmatchcheckout.step3', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'digital' => $dp, 'curr' => $curr, 'shipping_data' => $shipping_data, 'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id, 'paystack' => $paystackData, 'step2' => $step2, 'step1' => $step1, 'cashbacks' => $cashbacks, 'cashback_percentage' => $cashback_percentage]);
            }
        }
    }

    public function paycancle()
    {

        return redirect()->route('user-mix_match_cart')->with('unsuccess', __('Payment Cancelled.'));
    }

    // Redirect To Success Page If Payment is Comleted

    public function payreturn()
    {
        if (Session::has('tempcart')) {
            $oldCart = Session::get('tempcart');
            $tempcart = new Cart($oldCart);
            $order = Session::get('temporder');
        } else {
            $tempcart = '';
            return redirect()->back();
        }

        return view('frontend.mixmatchcheckout.success', compact('tempcart', 'order'));
    }
}
