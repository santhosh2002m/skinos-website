<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Api\Front\FrontBaseController;
use App\Models\Cart;
use App\Models\Country;
use App\Models\DiscountSlab;
use App\Models\Generalsetting;
use App\Models\Product;
use App\Models\SchemeEntries;
use App\Models\State;
use App\Models\UserCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;

class CartController extends FrontBaseController
{
    public function cart(Request $request)
    {
        $user = Auth::user();
        $user_type = $user->preferred_type ?? null;
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $products = $cart->items;
        $totalPrice = $cart->totalPrice;
        $mainTotal = $totalPrice;
        $totalDiscount = 0;
        $discountSlab = [];

        if ($user_type == "net_discount_profile") {
            $totalDiscount = $cart->totalDiscount;
            $discountSlab = DiscountSlab::where('status', 1)->get();
        }

        if (!Session::has('cart')) {
            return response()->json(['status' => false, 'message' => 'Cart is empty', 'data' => []]);
        }

        Session::forget(['already', 'coupon', 'coupon_total', 'coupon_total1']);

        return response()->json([
            'status' => true,
            'message' => 'Cart data retrieved',
            'data' => compact('user_type', 'discountSlab', 'products', 'totalPrice', 'totalDiscount', 'mainTotal')
        ]);
    }

    public function cartview()
    {
        $user = Auth::user();
        $cart = UserCart::where('user_id', $user->id)->first();

        return response()->json([
            'status' => true,
            'message' => $cart ? "Cart Fetched Successfully" : "The Cart is Empty",
            'data' => $cart ? json_decode($cart->cart_data) : [],
        ]);
    }


    public function addcart(Request $request, $id)
    {
        $prod = Product::where('id', '=', $id)->first([
            'id',
            'user_id',
            'slug',
            'name',
            'photo',
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
            'stock_check',
            'measure',
            'whole_sell_qty',
            'whole_sell_discount',
            'attributes',
            'color_all',
            'color_price'
        ]);

        $user = Auth::user();
        $userCart = UserCart::where('user_id', $user->id)->first();
        $scheme_id = $request->get('scheme_id');
        $product_quantity = $request->get('product_quantity');
        $user_type = $user->preferred_type;
        $selectedScheme = null;

        if (!empty($scheme_id)) {
            $selectedScheme = SchemeEntries::find($scheme_id);
        }

        // License check
        if (!empty($prod->license_qty)) {
            $lcheck = collect($prod->license_qty)->filter(fn($qty) => $qty >= 1)->count() > 0;
            if (!$lcheck) return response()->json(['status' => false, 'message' => 'License unavailable']);
        }

        // check stock
        if ($prod->stock_check && !is_null($prod->stock)) {
            if ($prod->stock < $product_quantity) {
                return response()->json([
                    'status' => false,
                    'message' => 'Out of Stock',
                    'suggestion' => 'Reduce the quantity of the products',
                    'cart' => []
                ]);
            }
        }

        // Size
        $size = !empty($prod->size) ? str_replace(' ', '-', trim($prod->size[0])) : '';

        // Color
        $color = !empty($prod->color) ? str_replace('#', '', $prod->color[0]) : '';

        // Vendor commission
        if ($prod->user_id != 0) {
            $gs = Generalsetting::findOrFail(1);
            $prod->price += $gs->fixed_commission + ($prod->price / 100) * $gs->percentage_commission;
        }

        // Attributes
        $keys = '';
        $values = '';
        if (!empty($prod->attributes)) {
            $attrArr = json_decode($prod->attributes, true);
            foreach ($attrArr as $attrKey => $attrVal) {
                if (isset($attrVal['details_status']) && $attrVal['details_status'] == 1) {
                    $keys .= $attrKey . ',';
                    $values .= $attrVal['values'][0] . ',';
                    $prod->price += $attrVal['prices'][0];
                }
            }
        }

        $keys = rtrim($keys, ',');
        $values = rtrim($values, ',');

        // Load cart from DB or start new
        $cartData = $userCart ? json_decode($userCart->cart_data, true) : ['items' => [], 'totalPrice' => 0, 'totalDiscount' => 0];
        $uniqueKey = $id . $size . $color . str_replace(str_split(' ,'), '', $values);

        // Digital product check
        if (isset($cartData['items'][$uniqueKey]) && @$cartData['items'][$uniqueKey]['dp'] == 1) {
            return response()->json(['status' => false, 'message' => 'Digital item already exists']);
        }

        // Set Quantity
        $qty = $user_type === "scheme_based_profile"
            ? $selectedScheme->total_quantity
            : ($product_quantity ?? 1);

        // Size price
        $size_price = $prod->size_price[0] ?? 0;
        $base_price = $prod->price + $size_price;
        $discount = 0;

        if ($user_type === "scheme_based_profile" && $selectedScheme->discount_percentage) {
            $discount = $base_price * ($selectedScheme->discount_percentage / 100);
            $base_price -= $discount;
        }

        // Set stored item
        $storedItem = [
            'user_id'     => $prod->user_id,
            'qty'         => $qty,
            'size_key'    => 0,
            'size_qty'    => $prod->size_qty[0] ?? null,
            'size_price'  => $size_price,
            'size'        => $size,
            'color'       => $color,
            'stock'       => $prod->stock,
            'price'       => $base_price * $qty,
            'is_mix_match'=>  false,
            'mix_match_batch'=> null,
            'item'        => $prod,
            'license'     => '',
            'dp'          => $prod->type !== 'Physical' ? 1 : 0,
            'keys'        => $keys,
            'values'      => $values,
            'item_price'  => $base_price,
            'discount'    => $discount,
            'affilate_user' => 0,
        ];

        if ($user_type === "scheme_based_profile") {
            $storedItem['scheme'] = $selectedScheme;
        }

        // Wholesale discount
        if (!empty($prod->whole_sell_qty)) {
            foreach (array_combine($prod->whole_sell_qty, $prod->whole_sell_discount) as $ws_qty => $ws_discount) {
                if ($qty == $ws_qty) {
                    $storedItem['discount'] = $ws_discount;
                    $storedItem['price'] = ($base_price - $ws_discount) * $qty;
                    break;
                }
            }
        }

        $cartData['items'][$uniqueKey] = $storedItem;

        // Recalculate totals
        $cartData['totalPrice'] = 0;
        foreach ($cartData['items'] as $item) {
            $cartData['totalPrice'] += $item['price'];
        }

        // Net Discount Profile Total Discount
        if ($user_type === "net_discount_profile") {
            $slabs = \App\Models\DiscountSlab::where('status', 1)->orderBy('min_value', 'asc')->get();
            $applicable = $slabs->first(
                fn($slab) =>
                $cartData['totalPrice'] >= $slab->min_value &&
                    ($slab->max_value === null || $cartData['totalPrice'] <= $slab->max_value)
            );

            if ($applicable) {
                $discountAmount = ($applicable->discount_percentage / 100) * $cartData['totalPrice'];
                $cartData['totalDiscount'] = $discountAmount;
                $cartData['totalPrice'] -= $discountAmount;
            } else {
                $cartData['totalDiscount'] = 0;
            }
        } else {
            $cartData['totalDiscount'] = 0;
        }

        // Save to DB
        UserCart::updateOrCreate(
            ['user_id' => $user->id],
            ['cart_data' => json_encode($cartData)]
        );

        return response()->json([
            'status' => true,
            'message' => 'Item added to cart',
            'cart_count' => count($cartData['items']),
            'cart' => $cartData
        ]);
    }

    public function addMixAndMatchToCart(Request $request)
    {

        $user = auth()->user();
        $user_type = $user->preferred_type;
        $scheme = null;
        try {
            $scheme = SchemeEntries::findOrFail($request->scheme_id);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Scheme id is not found']);
        }
        $userCart = UserCart::firstOrNew(['user_id' => $user->id]);
        $cartData = $userCart->cart_data ? json_decode($userCart->cart_data, true) : ['items' => [], 'totalPrice' => 0, 'totalDiscount' => 0];
        foreach ($request['items'] as $itemData) {
            $product = Product::select([
                'id',
                'user_id',
                'slug',
                'name',
                'photo',
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
                'stock_check',
                'measure',
                'whole_sell_qty',
                'whole_sell_discount',
                'attributes',
                'color_all',
                'color_price'
            ])->where('id', $itemData['id'])->first();
            if (!$product) continue;
            // License check
            if (!empty($product->license_qty)) {
                $lcheck = collect($product->license_qty)->filter(fn($qty) => $qty >= 1)->count() > 0;
                if (!$lcheck) continue; // skip if license not available
            }
            
            $size = !empty($product->size) ? str_replace(' ', '-', trim($product->size[0])) : '';
            $color = !empty($product->color) ? str_replace('#', '', $product->color[0]) : '';
            
            // Commission
            // if ($product->user_id != 0) {
            //     $gs = Generalsetting::find(1);
            //     $product->price += $gs->fixed_commission + ($product->price / 100) * $gs->percentage_commission;
            // }
            
            // Attributes
            $keys = '';
            $values = '';
            if (!empty($product->attributes)) {
                $attrArr = json_decode($product->attributes, true);
                foreach ($attrArr as $attrKey => $attrVal) {
                    if (!empty($attrVal['details_status'])) {
                        $keys .= $attrKey . ',';
                        $values .= $attrVal['values'][0] . ',';
                        $product->price += $attrVal['prices'][0];
                    }
                }
            }
            $keys = rtrim($keys, ',');
            $values = rtrim($values, ',');
            
            $qty = $user_type === "scheme_based_profile" ? $scheme->quantity_of_items_per_box : 1;
            
            $size_price = $product->size_price[0] ?? 0;
            $base_price = $product->price + $size_price;
            $discount = 0;
            
            if ($user_type === "scheme_based_profile" && $scheme->discount_percentage) {
                $discount = $base_price * ($scheme->discount_percentage / 100);
                $base_price -= $discount;
            }
            
            $uniqueKey = 'mix_' . $itemData['uid'];
            $storedItem = [
                'user_id'     => $product->user_id,
                'qty'         => $qty,
                'size_key'    => 0,
                'size_qty'    => $product->size_qty[0] ?? null,
                'size_price'  => $size_price,
                'size'        => $size,
                'color'       => $color,
                'stock'       => $product->stock,
                'price'       => $base_price * $qty,
                'item'        => $product,
                'item_price'  => $base_price,
                'discount'    => $discount,
                'license'     => '',
                'dp'          => $product->type !== 'Physical' ? 1 : 0,
                'keys'        => $keys,
                'values'      => $values,
                'affilate_user' => 0,
                'is_mix_match' => true,
                'mix_match_batch' => $itemData['mix_match_batch'],
                'scheme'      => $scheme,
            ];
            
            // dd($cartData->items);
            $cartData['items'][$uniqueKey] = $storedItem;
        }
        
        // Recalculate totals
        $cartData['totalPrice'] = 0;
        foreach ($cartData['items'] as $item) {
            $cartData['totalPrice'] += $item['price'];
        }

        // Save
        $userCart->cart_data = json_encode($cartData);
        $userCart->save();

        return response()->json([
            'status' => true,
            'message' => 'Mix & Match items added successfully',
            'cart_count' => count($cartData['items']),
            'cart' => $cartData
        ]);
    }

    public function addtocart($id)
    {
        $product = Product::findOrFail($id);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $cart->quickAdd($product, $product->id);
        Session::put('cart', $cart);

        return response()->json(['status' => true, 'message' => 'Product quick added to cart', 'data' => $cart]);
    }

    public function addnumcart(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $qty = $request->qty ?? 1;
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        // $cart->addnum($product, $product->id, $qty);
        Session::put('cart', $cart);

        return response()->json(['status' => true, 'message' => 'Product added with quantity', 'data' => $cart]);
    }

    public function addtonumcart(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $qty = $request->qty ?? 1;
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $cart->addToNum($product, $product->id, $qty);
        Session::put('cart', $cart);

        return response()->json(['status' => true, 'message' => 'Product quantity updated', 'data' => $cart]);
    }

    public function addbyone(Request $request)
    {
        $user = Auth::user();
        $id = $request->input('item_key');
        $userCart = UserCart::where('user_id', $user->id)->first();
    
        if (!$userCart) {
            return response()->json(['status' => false, 'message' => 'Cart not found']);
        }
    
        $cartData = json_decode($userCart->cart_data);
    
        if (!isset($cartData->items->$id)) {
            return response()->json(['status' => false, 'message' => 'Item not found in cart']);
        }
    
        $item = $cartData->items->$id;
        $item->qty += 1;

        $item->price = $item->item_price * $item->qty;
    
        $cartData->items->$id = $item;

        $userCart->cart_data = json_encode($cartData);
        $userCart->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Item quantity incremented',
            'cart' => $cartData
        ]);
    }
    
    
    public function reducebyone(Request $request)
    {
        $user = Auth::user();
        $itemKey = $request->input('item_key');
    
        // Get or create the user cart
        $userCart = UserCart::firstOrCreate(['user_id' => $user->id]);
    
        // Handle null or invalid cart data
        $cartData = json_decode($userCart->cart_data);
        if (!$cartData || !isset($cartData->items->$itemKey)) {
            return response()->json(['status' => false, 'message' => 'Item not found in cart']);
        }
    
        $item = $cartData->items->$itemKey;
    
        // Decrease quantity
        $item->qty -= 1;
    
        if ($item->qty < 1) {
            // Remove item if qty is zero
            unset($cartData->items->$itemKey);
        } else {
            // Recalculate price if still in cart
            $item->price = $item->item_price * $item->qty;
            $cartData->items->$itemKey = $item;
        }
    
        // Recalculate total price and total quantity
        $cartData->totalPrice = 0;
        $cartData->totalQty = 0;
        foreach ($cartData->items as $cartItem) {
            $cartData->totalPrice += $cartItem->price;
            $cartData->totalQty += $cartItem->qty;
        }
    
        // Save updated cart
        $userCart->cart_data = json_encode($cartData);
        $userCart->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Item quantity decreased',
            'cart_count' => count((array) $cartData->items),
            'cart' => $cartData
        ]);
    }
    

    public function upcolor(Request $request)
    {
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        // $cart->updateColor($request->id, $request->color);
        Session::put('cart', $cart);

        return response()->json(['status' => true, 'message' => 'Color updated', 'data' => $cart]);
    }

    public function removecart(Request $request)
    {
        $user = Auth::user();
        $uniqueKey = $request->get('item_key');

        $userCart = UserCart::where('user_id', $user->id)->first();

        if (!$userCart) {
            return response()->json(['status' => false, 'message' => 'Cart is already empty.']);
        }

        $cartData = json_decode($userCart->cart_data, true);

        if (!isset($cartData['items'][$uniqueKey])) {
            return response()->json(['status' => false, 'message' => 'Item not found in cart.']);
        }

        // Remove item
        unset($cartData['items'][$uniqueKey]);

        // Recalculate totals
        $cartData['totalPrice'] = 0;
        foreach ($cartData['items'] as $item) {
            $cartData['totalPrice'] += $item['price'];
        }

        // Recalculate net discount if needed
        $user_type = $user->preferred_type;
        if ($user_type === "net_discount_profile") {
            $slabs = DiscountSlab::where('status', 1)->orderBy('min_value', 'asc')->get();
            $applicable = $slabs->first(
                fn($slab) =>
                $cartData['totalPrice'] >= $slab->min_value &&
                    ($slab->max_value === null || $cartData['totalPrice'] <= $slab->max_value)
            );

            if ($applicable) {
                $discountAmount = ($applicable->discount_percentage / 100) * $cartData['totalPrice'];
                $cartData['totalDiscount'] = $discountAmount;
                $cartData['totalPrice'] -= $discountAmount;
            } else {
                $cartData['totalDiscount'] = 0;
            }
        } else {
            $cartData['totalDiscount'] = 0;
        }

        if (empty($cartData['items'])) {
            $userCart->delete();
        } else {
            $userCart->cart_data = json_encode($cartData);
            $userCart->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Item removed from cart.',
            'cart_count' => count($cartData['items']),
            'cart' => $cartData
        ]);
    }

    public function removeMixAndMatchBatch(Request $request)
    {
        $user = Auth::user();
        $batch_id = $request->get('batch_id');

        $userCart = UserCart::where('user_id', $user->id)->first();

        if (!$userCart) {
            return response()->json(['status' => false, 'message' => 'Cart is already empty.']);
        }

        $cartData = json_decode($userCart->cart_data, true);

        $updatedItems = [];
        $totalPrice = 0;

        foreach ($cartData['items'] as $key => $item) {
            if (!isset($item['mix_match_batch']) || $item['mix_match_batch'] != $batch_id) {
                $updatedItems[$key] = $item;
                $totalPrice += $item['price'];
            }
        }

        $cartData['items'] = $updatedItems;
        $cartData['totalPrice'] = $totalPrice;

        // Recalculate discount if needed
        $user_type = $user->preferred_type;
        if ($user_type === "net_discount_profile") {
            $slabs = DiscountSlab::where('status', 1)->orderBy('min_value', 'asc')->get();
            $applicable = $slabs->first(
                fn($slab) =>
                    $cartData['totalPrice'] >= $slab->min_value &&
                    ($slab->max_value === null || $cartData['totalPrice'] <= $slab->max_value)
            );

            if ($applicable) {
                $discountAmount = ($applicable->discount_percentage / 100) * $cartData['totalPrice'];
                $cartData['totalDiscount'] = $discountAmount;
                $cartData['totalPrice'] -= $discountAmount;
            } else {
                $cartData['totalDiscount'] = 0;
            }
        } else {
            $cartData['totalDiscount'] = 0;
        }

        if (empty($cartData['items'])) {
            $userCart->delete();
        } else {
            $userCart->cart_data = json_encode($cartData);
            $userCart->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Mix and Match batch removed from cart.',
            'cart_count' => count($cartData['items']),
            'cart' => $cartData
        ]);
    }

}
