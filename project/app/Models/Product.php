<?php

namespace App\Models;

use App\Models\Currency;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Product extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'product_type', 'affiliate_link', 'sku', 'subcategory_id', 'childcategory_id',
        'attributes', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'details', 'price', 'previous_price',
        'stock', 'policy', 'status', 'views', 'tags', 'featured', 'best', 'top', 'hot', 'latest', 'big', 'trending',
        'popular', 'features', 'colors', 'product_condition', 'ship', 'meta_tag', 'meta_description', 'youtube', 'type',
        'file', 'license', 'license_qty', 'link', 'platform', 'region', 'licence_type', 'measure', 'discount_date',
        'is_discount', 'whole_sell_qty', 'whole_sell_discount', 'catalog_id', 'slug', 'flash_count', 'hot_count',
        'new_count', 'sale_count', 'best_seller_count', 'popular_count', 'top_rated_count', 'big_save_count',
        'trending_count', 'page_count', 'seller_product_count', 'wishlist_count', 'vendor_page_count', 'min_price',
        'max_price', 'product_page', 'post_count', 'minimum_qty', 'preordered', 'color_all', 'size_all', 'color_price',
        'stock_check', 'cross_products', 'description', 'safety_information', 'clinical_evidences', 'usage_instructions',
        'technology', 'ingredients', 'brand_id'
    ];

    public $selectable = ['id', 'user_id', 'name', 'slug', 'features', 'colors', 'thumbnail', 'price', 'previous_price', 'attributes', 'size', 'size_price', 'discount_date', 'color_all', 'size_all', 'stock_check', 'category_id', 'details', 'type'];

    public $with = ['brand', 'brand.scheme','brand.scheme.scheme_entries'];

    public function scopeHome($query)
    {
        return $query->where('status', '=', 1)->select($this->selectable)->latest('id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category')->withDefault();
    }
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand')->withDefault();
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Models\Subcategory')->withDefault();
    }

    public function childcategory()
    {
        return $this->belongsTo('App\Models\Childcategory')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withDefault();
    }

    public function wishlist()
    {
        return $this->belongsTo('App\Models\Wishlist')->withDefault();
    }

    public function galleries()
    {
        return $this->hasMany('App\Models\Gallery');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function wishlists()
    {
        return $this->hasMany('App\Models\Wishlist');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function clicks()
    {
        return $this->hasMany('App\Models\ProductClick');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report', 'product_id');
    }

    public function IsSizeColor($value)
    {
        $sizes = array_unique($this->size);
        return in_array($value, $sizes);
    }

    public function checkVendor()
    {
        return $this->user_id != 0 ? '<small class="ml-2"> ' . __("VENDOR") . ': <a href="' . route('admin-vendor-show', $this->user_id) . '" target="_blank">' . $this->user->shop_name . '</a></small>' : '';
    }
    public function vendorPrice()
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $price = $this->price;
        if ($this->user_id != 0) {
            $price = $this->price + $gs->fixed_commission + ($this->price / 100) * $gs->percentage_commission;
        }

        return $price;
    }

    public function vendorSizePrice()
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $price = $this->price;
        if ($this->user_id != 0) {
            $price = $this->price + $gs->fixed_commission + ($this->price / 100) * $gs->percentage_commission;
        }
        if (!empty($this->size)) {
            $price += $this->size_price[0];
        }

        // Attribute Section

        $attributes = $this->attributes["attributes"];
        if (!empty($attributes)) {
            $attrArr = json_decode($attributes, true);
        }

        if (!empty($attrArr)) {
            foreach ($attrArr as $attrKey => $attrVal) {
                if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {

                    foreach ($attrVal['values'] as $optionKey => $optionVal) {
                        $price += $attrVal['prices'][$optionKey];
                        // only the first price counts
                        break;
                    }
                }
            }
        }

        // Attribute Section Ends
        return $price;
    }

    public function setCurrency()
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $price = $this->price;
        if (Session::has('currency')) {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return Currency::find(Session::get('currency'));
            });
        } else {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return Currency::where('is_default', '=', 1)->first();
            });
        }
        $price = $price * $curr->value;
        $price = \PriceHelper::showPrice($price);
        if ($gs->currency_format == 0) {
            return $curr->sign . $price;
        } else {
            return $price . $curr->sign;
        }
    }

    public function showPrice()
    {
        $id = $this->id;
        $product = Product::find($id);

        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $price = $product->price;

        if ($product->user_id != 0) {
            $price = $product->price + $gs->fixed_commission + ($product->price / 100) * $gs->percentage_commission;
        }

        if (!empty($product->size)) {
            $price += $product->size_price[0];
        }

        // Attribute Section

        $attributes = $product->attributes["attributes"];
        if (!empty($attributes)) {
            $attrArr = json_decode($attributes, true);
        }

        if (!empty($attrArr)) {
            foreach ($attrArr as $attrKey => $attrVal) {
                if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {

                    foreach ($attrVal['values'] as $optionKey => $optionVal) {
                        $price += $attrVal['prices'][$optionKey];
                        // only the first price counts
                        break;
                    }
                }
            }
        }

        // Attribute Section Ends

        if (Session::has('currency')) {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return Currency::find(Session::get('currency'));
            });
        } else {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return Currency::where('is_default', '=', 1)->first();
            });
        }

        $price = $price * $curr->value;
        $price = \PriceHelper::showPrice($price);

        if ($gs->currency_format == 0) {
            // return $curr->sign . $price;
            return  "
            <span class='price-sign'>" . $curr->sign  . "</span>
            <span class='individual-price'>".$price."</span>
            ";
        } else {
            // return $price . $curr->sign;
            return  "
            <span class='individual-price'>".$price."</span>
            <span class='price-sign'>" . $curr->sign  . "</span>
            ";
        }
    }

    public function adminShowPrice()
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $price = $this->price;

        if ($this->user_id != 0) {
            $price = $this->price + $gs->fixed_commission + ($this->price / 100) * $gs->percentage_commission;
        }

        if (!empty($this->size)) {
            $price += $this->size_price[0];
        }

        // Attribute Section

        $attributes = $this->attributes["attributes"];
        if (!empty($attributes)) {
            $attrArr = json_decode($attributes, true);
        }

        if (!empty($attrArr)) {
            foreach ($attrArr as $attrKey => $attrVal) {
                if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {

                    foreach ($attrVal['values'] as $optionKey => $optionVal) {
                        $price += $attrVal['prices'][$optionKey];
                        // only the first price counts
                        break;
                    }
                }
            }
        }

        // Attribute Section Ends

        $curr = Currency::where('is_default', '=', 1)->first();
        $price = $price * $curr->value;
        $price = \PriceHelper::showPrice($price);

        if ($gs->currency_format == 0) {
            return $curr->sign . $price;
        } else {
            return $price . $curr->sign;
        }
    }

    public function showPreviousPrice()
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $price = $this->previous_price;
        if (!$price) {
            return 0;
        }
        if ($this->user_id != 0) {
            $price = $this->previous_price + $gs->fixed_commission + ($this->previous_price / 100) * $gs->percentage_commission;
        }

        if (!empty($this->size)) {
            $price += $this->size_price[0];
        }

        // Attribute Section

        $attributes = $this->attributes["attributes"];
        if (!empty($attributes)) {
            $attrArr = json_decode($attributes, true);
        }

        if (!empty($attrArr)) {
            foreach ($attrArr as $attrKey => $attrVal) {
                if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {

                    foreach ($attrVal['values'] as $optionKey => $optionVal) {
                        $price += $attrVal['prices'][$optionKey];
                        // only the first price counts
                        break;
                    }
                }
            }
        }

        // Attribute Section Ends

        if (Session::has('currency')) {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return Currency::find(Session::get('currency'));
            });
        } else {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return Currency::where('is_default', '=', 1)->first();
            });
        }

        $price = $price * $curr->value;
        $price = \PriceHelper::showPrice($price);


        if ($gs->currency_format == 0) {
            return $curr->sign . $price;
        } else {
            return $price . $curr->sign;
        }


    }

    public static function convertPrice($price)
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        if (Session::has('currency')) {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return Currency::find(Session::get('currency'));
            });
        } else {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return Currency::where('is_default', '=', 1)->first();
            });
        }
        $price = $price * $curr->value;
        $price = \PriceHelper::showPrice($price);
        if ($gs->currency_format == 0) {
            return $curr->sign . $price;
        } else {
            return $price . $curr->sign;
        }
    }

    public static function vendorConvertPrice($price)
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });

        if (Session::has('currency')) {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return Currency::find(Session::get('currency'));
            });
        } else {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return Currency::where('is_default', '=', 1)->first();
            });
        }
        $price = $price * $curr->value;
        $price = \PriceHelper::showPrice($price);
        if ($gs->currency_format == 0) {
            return $curr->sign . $price;
        } else {
            return $price . $curr->sign;
        }
    }

    public static function vendorConvertWithoutCurrencyPrice($price)
    {

        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }

        $price = $price * $curr->value;
        $price = \PriceHelper::showPrice($price);
        return $price;
    }

    public function showName()
    {
        $name = mb_strlen($this->name, 'UTF-8') > 50 ? mb_substr($this->name, 0, 50, 'UTF-8') . '...' : $this->name;
        return $name;
    }

    public function emptyStock()
    {

        $stck = (string) $this->stock;
        if ($stck == "0") {
            return true;
        }
        return false;
    }

    public static function showTags()
    {
        $tags = null;
        $tagz = '';
        $name = Product::where('status', '=', 1)->pluck('tags')->toArray();
        foreach ($name as $nm) {
            if (!empty($nm)) {
                foreach ($nm as $n) {
                    $tagz .= $n . ',';
                }
            }
        }
        $tags = array_unique(explode(',', $tagz));
        return $tags;
    }

    public function is_decimal($val)
    {
        return is_numeric($val) && floor($val) != $val;
    }

    public function getColorallAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(",", $value);
    }

    public function getColorPriceAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',', $value);
    }

    public function getSizeAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',', $value);
    }

    public function getSizeQtyAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',', $value);
    }

    public function getSizePriceAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',', $value);
    }

    public function getColorAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',', $value);
    }

    public function getTagsAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',', $value);
    }

    public function getMetaTagAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',', $value);
    }

    public function getFeaturesAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',', $value);
    }

    public function getColorsAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',', $value);
    }

    public function getLicenseAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',,', $value);
    }

    public function getLicenseQtyAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',', $value);
    }

    public function getWholeSellQtyAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',', $value);
    }

    public function getWholeSellDiscountAttribute($value)
    {
        if ($value == null) {
            return '';
        }
        return explode(',', $value);
    }

    public function offPercentage()
    {

        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $price = $this->price;
        $preprice = $this->previous_price;
        if (!$preprice) {
            return 0;
        }

        if ($this->user_id != 0) {
            $price = $this->price + $gs->fixed_commission + ($this->price / 100) * $gs->percentage_commission;
            $preprice = $this->previous_price + $gs->fixed_commission + ($this->previous_price / 100) * $gs->percentage_commission;
        }

        if (!empty($this->size)) {
            $price += $this->size_price[0];
            $preprice += $this->size_price[0];
        }

        // Attribute Section

        $attributes = $this->attributes["attributes"];
        if (!empty($attributes)) {
            $attrArr = json_decode($attributes, true);
        }

        if (!empty($attrArr)) {
            foreach ($attrArr as $attrKey => $attrVal) {
                if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {

                    foreach ($attrVal['values'] as $optionKey => $optionVal) {
                        $price += $attrVal['prices'][$optionKey];
                        // only the first price counts
                        $preprice += $attrVal['prices'][$optionKey];
                        break;
                    }
                }
            }
        }

        // Attribute Section Ends

        if (Session::has('currency')) {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return Currency::find(Session::get('currency'));
            });
        } else {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return Currency::where('is_default', '=', 1)->first();
            });
        }

        $price = $price * $curr->value;
        $preprice = $preprice * $curr->value;
        $Percentage = (($preprice - $price) * 100) / $preprice;

        if ($Percentage) {
            return $Percentage;
        }
    }

    public static function filterProducts($collection)
    {
        foreach ($collection as $key => $data) {
            if ($data->user_id != 0) {
                if ($data->user->is_vendor != 2) {
                    unset($collection[$key]);
                }
            }
            if (isset($_GET['max'])) {
                if ($data->vendorSizePrice() >= $_GET['max']) {
                    unset($collection[$key]);
                }
            }
            $data->price = $data->vendorSizePrice();
        }
        return $collection;
    }

    // MOBILE API SECTION

    public function ApishowPrice()
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $price = $this->price;

        if ($this->user_id != 0) {
            $price = $this->price + $gs->fixed_commission + ($this->price / 100) * $gs->percentage_commission;
        }

        if (!empty($this->size)) {
            $price += $this->size_price[0];
        }

        // Attribute Section

        $attributes = $this->attributes["attributes"];
        if (!empty($attributes)) {
            $attrArr = json_decode($attributes, true);
        }

        if (!empty($attrArr)) {
            foreach ($attrArr as $attrKey => $attrVal) {
                if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {

                    foreach ($attrVal['values'] as $optionKey => $optionVal) {
                        $price += $attrVal['prices'][$optionKey];
                        // only the first price counts
                        break;
                    }
                }
            }
        }

        // Attribute Section Ends

        if (Session::has('currency')) {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return Currency::find(Session::get('currency'));
            });
        } else {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return Currency::where('is_default', '=', 1)->first();
            });
        }

        $price = $price * $curr->value;
        $price = \PriceHelper::apishowPrice($price);
        return $price;
    }

    public function ApishowDetailsPrice()
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $price = $this->price;

        if ($this->user_id != 0) {
            $price = $this->price + $gs->fixed_commission + ($this->price / 100) * $gs->percentage_commission;
        }

        // Attribute Section

        $attributes = $this->attributes["attributes"];
        if (!empty($attributes)) {
            $attrArr = json_decode($attributes, true);
        }

        if (!empty($attrArr)) {
            foreach ($attrArr as $attrKey => $attrVal) {
                if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {

                    foreach ($attrVal['values'] as $optionKey => $optionVal) {
                        $price += $attrVal['prices'][$optionKey];
                        // only the first price counts
                        break;
                    }
                }
            }
        }

        // Attribute Section Ends

        if (Session::has('currency')) {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return Currency::find(Session::get('currency'));
            });
        } else {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return Currency::where('is_default', '=', 1)->first();
            });
        }

        $price = $price * $curr->value;
        $price = \PriceHelper::apishowPrice($price);

        return $price;
    }

    public function ApishowPreviousPrice()
    {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });
        $price = $this->previous_price;
        if (!$price) {
            return 0;
        }
        if ($this->user_id != 0) {
            $price = $this->previous_price + $gs->fixed_commission + ($this->previous_price / 100) * $gs->percentage_commission;
        }

        if (!empty($this->size)) {
            $price += $this->size_price[0];
        }

        // Attribute Section

        $attributes = $this->attributes["attributes"];
        if (!empty($attributes)) {
            $attrArr = json_decode($attributes, true);
        }
        // dd($attrArr);
        if (!empty($attrArr)) {
            foreach ($attrArr as $attrKey => $attrVal) {
                if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {

                    foreach ($attrVal['values'] as $optionKey => $optionVal) {
                        $price += $attrVal['prices'][$optionKey];
                        // only the first price counts
                        break;
                    }
                }
            }
        }

        // Attribute Section Ends

        if (Session::has('currency')) {
            $curr = cache()->remember('session_currency', now()->addDay(), function () {
                return Currency::find(Session::get('currency'));
            });
        } else {
            $curr = cache()->remember('default_currency', now()->addDay(), function () {
                return Currency::where('is_default', '=', 1)->first();
            });
        }

        $price = $price * $curr->value;
        $price = \PriceHelper::apishowPrice($price);

        return $price;
    }
}
