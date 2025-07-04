<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Session;

class Cart extends Model
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    //Used only for the Net Discount Profile
    public $totalDiscount = 0;

    public function __construct($oldCart = null)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
            $this->totalDiscount = $oldCart->totalDiscount;
        }
    }

    // ************** ADD TO CART *****************

    public function add($item, $id, $size, $color, $keys, $values)
    {

        $size_cost = 0;
        $storedItem = ['user_id' => $item->user_id, 'qty' => 0, 'size_key' => 0, 'size_qty' => $item->size_qty, 'size_price' => $item->size_price, 'size' => $item->size, 'color' => $item->color, 'stock' => $item->stock, 'price' => $item->price, 'item' => $item, 'license' => '', 'dp' => '0', 'keys' => $keys, 'values' => $values, 'item_price' => $item->price, 'discount' => 0, 'affilate_user' => 0];
        if ($item->type == 'Physical') {
            if ($this->items) {
                if (array_key_exists($id . $size . $color . str_replace(str_split(' ,'), '', $values), $this->items)) {
                    $storedItem = $this->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)];
                }
            }
        } else {
            if ($this->items) {
                if (array_key_exists($id . $size . $color . str_replace(str_split(' ,'), '', $values), $this->items)) {
                    $storedItem = $this->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)];
                }
            }
            $storedItem['dp'] = 1;
        }
        $storedItem['qty']++;
        $stck = (string) $item->stock;
        if ($stck != null) {
            $storedItem['stock']--;
        }
        if (!empty($item->size)) {
            $storedItem['size'] = $item->size[0];
        }

        if (!empty($size)) {
            $storedItem['size'] = $size;
        }
        if (!empty($item->size_qty)) {
            $storedItem['size_qty'] = $item->size_qty[0];
        }
        if ($item->size_price != null) {
            $storedItem['size_price'] = $item->size_price[0];
            $size_cost = $item->size_price[0];
        }
        if (!empty($color)) {
            $storedItem['color'] = $color;
        }

        if (!empty($keys)) {
            $storedItem['keys'] = $keys;
        }
        if (!empty($values)) {
            $storedItem['values'] = $values;
        }
        $item->price += $size_cost;
        $storedItem['item_price'] = $item->price;
        if (!empty($item->whole_sell_qty)) {
            foreach (array_combine($item->whole_sell_qty, $item->whole_sell_discount) as $whole_sell_qty => $whole_sell_discount) {
                if ($storedItem['qty'] == $whole_sell_qty) {
                    $whole_discount[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] = $whole_sell_discount;
                    Session::put('current_discount', $whole_discount);
                    $storedItem['discount'] = $whole_sell_discount;
                    break;
                }
            }
            if (Session::has('current_discount')) {
                $data = Session::get('current_discount');
                if (array_key_exists($id . $size . $color . str_replace(str_split(' ,'), '', $values), $data)) {
                    $discount = $item->price * ($data[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] / 100);
                    $item->price = $item->price - $discount;
                }
            }
        }

        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] = $storedItem;
        $this->totalQty++;
    }

    // ************** ADD TO CART ENDS *****************
    // ************** ADD TO SCHEME PRODUCT to CART *****************

    public function addSchemeProduct($item, $id, $size, $color, $keys, $values, $scheme, $mix_match_item)
    {
        $size_cost = 0;
        $uniqueKey = $id . $size . $color . str_replace(str_split(' ,'), '', $values);

        // if (isset($this->items[$uniqueKey])) {
        //     return;
        // }

        $storedItem = [
            'user_id'     => $item->user_id,
            'qty'         => $mix_match_item['is_mix_match'] ? $scheme->quantity_of_items_per_box : $scheme->total_quantity,
            'size_key'    => 0,
            'size_qty'    => $item->size_qty[0] ?? null,
            'size_price'  => $item->size_price[0] ?? null,
            'size'        => $size ?? null,
            'color'       => $color,
            'stock'       => $item->stock,
            'price'       => $item->price,
            'is_mix_match'=> $mix_match_item->is_mix_match ?? false,
            'mix_match_batch'=> $mix_match_item['is_mix_match'] ? $mix_match_item['mix_match_batch'] : null,
            // Need to add uniques for teh bacth and render based on that on the frontend
            'item'        => $item,
            'license'     => '',
            'dp'          => $item->type !== 'Physical' ? 1 : 0,
            'keys'        => $keys,
            'values'      => $values,
            'item_price'  => $item->price,
            'discount'    => $scheme->discount_percentage,
            'affilate_user' => 0
        ];

        if (!empty($item->size_price)) {
            $storedItem['size_price'] = $item->size_price[0];
            $size_cost = $item->size_price[0];
        }

        $item->price += $size_cost;
        $storedItem['scheme'] = $scheme;
        $storedItem['item_price'] = $item->price;

        if (!empty($item->whole_sell_qty)) {
            foreach (array_combine($item->whole_sell_qty, $item->whole_sell_discount) as $whole_sell_qty => $whole_sell_discount) {
                if ($storedItem['qty'] == $whole_sell_qty) {
                    $whole_discount[$uniqueKey] = $whole_sell_discount;
                    Session::put('current_discount', $whole_discount);
                    $storedItem['discount'] = $whole_sell_discount;
                    break;
                }
            }
        }
        if ($scheme->discount_percentage) {
            $discount = $item->price * ($scheme->discount_percentage / 100);
            $item->price -= $discount;
        }

        $storedItem['price'] = $item->price * $storedItem['qty'];

        $this->items[$uniqueKey] = $storedItem;
        $this->totalQty++;
    }


    // ************** ADD TO SCHEME PRODUCT to CART ENDS *****************
    // ************** ADD TO NET DISCOUNT PRODUCT to CART *****************

    public function addNetDiscountProduct($item, $id, $size, $color, $keys, $values, $quantity)
    {

        $size_cost = 0;
        $storedItem = ['user_id' => $item->user_id, 'qty' => 0, 'size_key' => 0, 'size_qty' => $item->size_qty, 'size_price' => $item->size_price, 'size' => $item->size, 'color' => $item->color, 'stock' => $item->stock, 'price' => $item->price, 'item' => $item, 'license' => '', 'dp' => '0', 'keys' => $keys, 'values' => $values, 'item_price' => $item->price, 'discount' => 0, 'affilate_user' => 0];
        if ($item->type == 'Physical') {
            if ($this->items) {
                if (array_key_exists($id . $size . $color . str_replace(str_split(' ,'), '', $values), $this->items)) {
                    $storedItem = $this->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)];
                }
            }
        } else {
            if ($this->items) {
                if (array_key_exists($id . $size . $color . str_replace(str_split(' ,'), '', $values), $this->items)) {
                    $storedItem = $this->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)];
                }
            }
            $storedItem['dp'] = 1;
        }
        $storedItem['qty']++;
        $stck = (string) $item->stock;
        if ($stck != null) {
            $storedItem['stock']--;
        }
        if (!empty($item->size)) {
            $storedItem['size'] = $item->size[0];
        }

        if (!empty($size)) {
            $storedItem['size'] = $size;
        }
        if (!empty($item->size_qty)) {
            $storedItem['size_qty'] = $item->size_qty[0];
        }
        if ($item->size_price != null) {
            $storedItem['size_price'] = $item->size_price[0];
            $size_cost = $item->size_price[0];
        }
        if (!empty($color)) {
            $storedItem['color'] = $color;
        }

        if (!empty($keys)) {
            $storedItem['keys'] = $keys;
        }
        if (!empty($values)) {
            $storedItem['values'] = $values;
        }
        $item->price += $size_cost;
        $storedItem['item_price'] = $item->price;
        if (!empty($item->whole_sell_qty)) {
            // foreach (array_combine($item->whole_sell_qty, $item->whole_sell_discount) as $whole_sell_qty => $whole_sell_discount) {
            //     if ($storedItem['qty'] == $whole_sell_qty) {
                //         $whole_discount[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] = $whole_sell_discount;
                //         Session::put('current_discount', $whole_discount);
                //         $storedItem['discount'] = $whole_sell_discount;
                //         break;
                //     }
                // }
            if (Session::has('current_discount')) {
                $data = Session::get('current_discount');
                if (array_key_exists($id . $size . $color . str_replace(str_split(' ,'), '', $values), $data)) {
                    $discount = $item->price * ($data[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] / 100);
                    $item->price = $item->price - $discount;
                }
            }
        }

        $storedItem['qty'] = $quantity;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] = $storedItem;
        $this->totalQty++;
    }


    // ************** ADD TO NET DISCOUNT CART ENDS *****************

    // ************** ADD TO CART MULTIPLE *****************

    public function addnum($item, $id, $qty, $size, $color, $size_qty, $size_price, $color_price, $size_key, $keys, $values, $affilate_user)
    {
        $size_cost = 0;
        $color_cost = 0;

        $storedItem = ['user_id' => $item->user_id, 'qty' => 0, 'size_key' => 0, 'size_qty' => $item->size_qty, 'size_price' => $item->size_price, 'size' => $item->size, 'color' => $item->color, "color_price" => $color_price, 'stock' => $item->stock, 'price' => $item->price, 'item' => $item, 'license' => '', 'dp' => '0', 'keys' => $keys, 'values' => $values, 'item_price' => $item->price, 'discount' => 0, 'affilate_user' => 0];
        if ($item->type == 'Physical') {
            if ($this->items) {
                if (array_key_exists($id . $size . $color . str_replace(str_split(' ,'), '', $values), $this->items)) {
                    $storedItem = $this->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)];
                }
            }
        } else {
            if ($this->items) {
                if (array_key_exists($id . $size . $color . str_replace(str_split(' ,'), '', $values), $this->items)) {
                    $storedItem = $this->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)];
                }
            }
            $storedItem['dp'] = 1;
        }
        $storedItem['affilate_user'] = $affilate_user;
        if (Auth::guard('admin')->check()) {
            $storedItem['qty'] = $qty;
        } else {
            $storedItem['qty'] = $storedItem['qty'] + $qty;
        }
        $stck = (string) $item->stock;
        if ($stck != null) {
            $storedItem['stock'] = $storedItem['stock'] - $qty;
        }
        if (!empty($item->size)) {
            $storedItem['size'] = $item->size[0];
        }
        if (!empty($size)) {
            $storedItem['size'] = $size;
        }
        if (!empty($size_key)) {
            $storedItem['size_key'] = $size_key;
        }
        if (!empty($item->size_qty)) {
            $storedItem['size_qty'] = $item->size_qty[0];
        }
        if (!empty($size_qty)) {
            $storedItem['size_qty'] = $size_qty;
        }


        if (!empty($item->size_price)) {
            $storedItem['size_price'] = $item->size_price[0];
            $size_cost = $item->size_price[0];
        }
        if (!empty($size_price)) {
            $storedItem['size_price'] = $size_price;
            $size_cost = $size_price;
        }

        if (!empty($item->color_price)) {
            $storedItem['color_price'] = $item->color_price[0];
            $color_cost = $item->color_price[0];
        }
        if (!empty($color_price)) {
            $storedItem['color_price'] = $color_price;
            $color_cost = $color_price;
        }


        if (!empty($item->color)) {
            $storedItem['color'] = $item->color[0];
        }
        if (!empty($color)) {
            $storedItem['color'] = $color;
        }
        if (!empty($keys)) {
            $storedItem['keys'] = $keys;
        }
        if (!empty($values)) {
            $storedItem['values'] = $values;
        }



        $item->price += $size_cost;
        $item->price += $color_cost;
        $storedItem['item_price'] = $item->price;
        if (!empty($item->whole_sell_qty)) {
            foreach ($item->whole_sell_qty as $key => $data) {
                if (($key + 1) != count($item->whole_sell_qty)) {
                    if (($storedItem['qty'] >= $item->whole_sell_qty[$key]) && ($storedItem['qty'] < $item->whole_sell_qty[$key + 1])) {
                        $whole_discount[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] = $item->whole_sell_discount[$key];
                        Session::put('current_discount', $whole_discount);
                        $storedItem['discount'] = $item->whole_sell_discount[$key];
                        break;
                    }
                } else {
                    if (($storedItem['qty'] >= $item->whole_sell_qty[$key])) {
                        $whole_discount[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] = $item->whole_sell_discount[$key];
                        Session::put('current_discount', $whole_discount);
                        $storedItem['discount'] = $item->whole_sell_discount[$key];
                        break;
                    }
                }
            }

            if (Session::has('current_discount')) {
                $data = Session::get('current_discount');
                if (array_key_exists($id . $size . $color . str_replace(str_split(' ,'), '', $values), $data)) {
                    $discount = $item->price * ($data[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] / 100);
                    $item->price = $item->price - $discount;
                }
            }
        }

        $storedItem['price'] = $item->price * $storedItem['qty'];



        $this->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] = $storedItem;
        $this->totalQty += $storedItem['qty'];
    }

    // ************** ADD TO CART MULTIPLE ENDS *****************

    // ************** ADDING QUANTITY *****************

    public function adding($item, $id, $size_qty, $size_price)
    {
        $storedItem = ['user_id' => $item->user_id, 'qty' => 0, 'size_key' => 0, 'size_qty' => $item->size_qty, 'size_price' => $item->size_price, 'size' => $item->size, 'color' => $item->color, 'stock' => $item->stock, 'price' => $item->price, 'item' => $item, 'license' => '', 'dp' => '0', 'keys' => '', 'values' => '', 'item_price' => $item->price, 'discount' => 0, 'affilate_user' => 0];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']++;

        if ($item->stock != null) {
            $storedItem['stock']--;
        }

        // CURRENCY ISSUE CHECK IT CAREFULLY

        $item->price += (float) $size_price;

        if (!empty($item->whole_sell_qty)) {
            foreach (array_combine($item->whole_sell_qty, $item->whole_sell_discount) as $whole_sell_qty => $whole_sell_discount) {
                if ($storedItem['qty'] == $whole_sell_qty) {
                    $whole_discount[$id] = $whole_sell_discount;
                    Session::put('current_discount', $whole_discount);
                    $storedItem['discount'] = $whole_sell_discount;
                    break;
                }
            }
            if (Session::has('current_discount')) {
                $data = Session::get('current_discount');
                if (array_key_exists($id, $data)) {
                    $discount = $item->price * ($data[$id] / 100);
                    $item->price = $item->price - $discount;
                }
            }
        }

        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty += $storedItem['qty'];
    }

    // ************** ADDING QUANTITY ENDS *****************

    // ************** REDUCING QUANTITY *****************

    public function reducing($item, $id, $size_qty, $size_price)
    {
        $storedItem = ['user_id' => $item->user_id, 'qty' => 0, 'size_key' => 0, 'size_qty' => $item->size_qty, 'size_price' => $item->size_price, 'size' => $item->size, 'color' => $item->color, 'stock' => $item->stock, 'price' => $item->price, 'item' => $item, 'license' => '', 'dp' => '0', 'keys' => '', 'values' => '', 'item_price' => $item->price, 'discount' => 0, 'affilate_user' => 0];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }

        if ($storedItem['qty'] == 1) {
            return;
        }

        $storedItem['qty']--;
        if ($item->stock != null) {
            $storedItem['stock']++;
        }

        // CURRENCY ISSUE CHECK IT CAREFULLY

        $item->price += (float) $size_price;
        if (!empty($item->whole_sell_qty)) {
            $len = count($item->whole_sell_qty);
            foreach ($item->whole_sell_qty as $key => $data1) {
                if ($storedItem['qty'] < $item->whole_sell_qty[$key]) {
                    if ($storedItem['qty'] < $item->whole_sell_qty[0]) {
                        Session::forget('current_discount');
                        $storedItem['discount'] = 0;
                        break;
                    }

                    $whole_discount[$id] = $item->whole_sell_discount[$key - 1];
                    Session::put('current_discount', $whole_discount);
                    $storedItem['discount'] = $item->whole_sell_discount[$key - 1];
                    break;
                }
            }
            if (Session::has('current_discount')) {
                $data = Session::get('current_discount');
                if (array_key_exists($id, $data)) {
                    $discount = $item->price * ($data[$id] / 100);
                    $item->price = $item->price - $discount;
                }
            }
        }

        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty--;
    }

    // ************** REDUCING QUANTITY ENDS *****************

    public function MobileupdateLicense($id, $license)
    {
        $this->items[$id]['license'] = $license;
    }
    public function updateLicense($id, $license)
    {

        $this->items[$id]['license'] = $license;
    }

    public function updateColor($item, $id, $color)
    {

        $this->items[$id]['color'] = $color;
    }

    public function removeItem($id)
    {
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
        if (Session::has('current_discount')) {
            $data = Session::get('current_discount');
            if (array_key_exists($id, $data)) {
                unset($data[$id]);
                Session::put('current_discount', $data);
            }
        }
    }
    public function removeMixAndMatchBatch($id, $batch_id)
    {
        foreach ($this->items as $id => $item) {
            if (isset($item['mix_match_batch']) && $item['mix_match_batch'] == $batch_id) {
                $this->totalQty -= $item['qty'];
                $this->totalPrice -= $item['price'];
                unset($this->items[$id]);

                // Remove from session discount if present
                if (Session::has('current_discount')) {
                    $data = Session::get('current_discount');
                    if (array_key_exists($id, $data)) {
                        unset($data[$id]);
                        Session::put('current_discount', $data);
                    }
                }
            }
        }
    }
}
