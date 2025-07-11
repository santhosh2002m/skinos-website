<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Currency;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Tag; // Added Tag model
use Datatables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;
use Validator;

class ProductController extends AdminBaseController
{
    //*** JSON Request
    public function datatables(Request $request)
    {
        // Existing datatables method remains unchanged
        if ($request->type == 'all') {
            $datas = Product::whereProductType('normal')->latest('id')->get();
        } else if ($request->type == 'deactive') {
            $datas = Product::whereProductType('normal')->whereStatus(0)->latest('id')->get();
        }

        return Datatables::of($datas)
            ->editColumn('name', function (Product $data) {
                $name = mb_strlen($data->name, 'UTF-8') > 50 ? mb_substr($data->name, 0, 50, 'UTF-8') . '...' : $data->name;
                $id = '<small>' . __("ID") . ': <a href="' . route('front.product', $data->slug) . '" target="_blank">' . sprintf("%'.08d", $data->id) . '</a></small>';
                $id3 = $data->type == 'Physical' ? '<small class="ml-2"> ' . __("SKU") . ': <a href="' . route('front.product', $data->slug) . '" target="_blank">' . $data->sku . '</a>' : '';
                return $name . '<br>' . $id . $id3 . $data->checkVendor();
            })
            ->editColumn('price', function (Product $data) {
                $price = $data->price * $this->curr->value;
                return \PriceHelper::showAdminCurrencyPrice($price);
            })
            ->editColumn('photo', function (Product $data) {
                $photo = $data->photo ? asset('assets/images/products/' . $data->photo) : asset('assets/images/noimage.png');
                return '<img src="' . $photo . '" alt="Image" class="img-thumbnail" style="width:80px">';
            })
            ->editColumn('stock', function (Product $data) {
                $stck = (string) $data->stock;
                if ($stck == "0") {
                    return __("Out Of Stock");
                } elseif ($stck == null) {
                    return __("Unlimited");
                } else {
                    return $data->stock;
                }
            })
            ->addColumn('status', function (Product $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-prod-status', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('admin-prod-status', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option></select></div>';
            })
            ->addColumn('action', function (Product $data) {
                // Removed $catalog variable and its logic
                return '<div class="godropdown"><button class="go-dropdown-toggle"> ' . __("Actions") . '<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit', $data->id) . '"> <i class="fas fa-edit"></i> ' . __("Edit") . '</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="' . $data->id . '"><i class="fas fa-eye"></i> ' . __("View Gallery") . '</a><a data-href="' . route('admin-prod-feature', $data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> ' . __("Highlight") . '</a><a href="javascript:;" data-href="' . route('admin-prod-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> ' . __("Delete") . '</a></div></div>';
            })
            ->rawColumns(['name', 'status', 'action', 'photo'])
            ->toJson();
    }

    //*** JSON Request
    public function catalogdatatables()
    {
        // Existing catalogdatatables method remains unchanged
        $datas = Product::where('is_catalog', '=', 1)->orderBy('id', 'desc');

        return Datatables::of($datas)
            ->editColumn('name', function (Product $data) {
                $name = mb_strlen($data->name, 'UTF-8') > 50 ? mb_substr($data->name, 0, 50, 'UTF-8') . '...' : $data->name;
                $id = '<small>' . __("ID") . ': <a href="' . route('front.product', $data->slug) . '" target="_blank">' . sprintf("%'.08d", $data->id) . '</a></small>';
                $id3 = $data->type == 'Physical' ? '<small class="ml-2"> ' . __("SKU") . ': <a href="' . route('front.product', $data->slug) . '" target="_blank">' . $data->sku . '</a>' : '';
                return $name . '<br>' . $id . $id3 . $data->checkVendor();
            })
            ->editColumn('price', function (Product $data) {
                $price = $data->price * $this->curr->value;
                return \PriceHelper::showAdminCurrencyPrice($price);
            })
            ->editColumn('stock', function (Product $data) {
                $stck = (string) $data->stock;
                if ($stck == "0") {
                    return __("Out Of Stock");
                } elseif ($stck == null) {
                    return __("Unlimited");
                } else {
                    return $data->stock;
                }
            })
            ->addColumn('status', function (Product $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-prod-status', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('admin-prod-status', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option></select></div>';
            })
            ->addColumn('action', function (Product $data) {
                return '<div class="godropdown"><button class="go-dropdown-toggle"> ' . __("Actions") . '<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit', $data->id) . '"> <i class="fas fa-edit"></i> ' . __("Edit") . '</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="' . $data->id . '"><i class="fas fa-eye"></i> ' . __("View Gallery") . '</a><a data-href="' . route('admin-prod-feature', $data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> ' . __("Highlight") . '</a><a href="javascript:;" data-href="' . route('admin-prod-catalog', ['id1' => $data->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#catalog-modal"><i class="fas fa-trash-alt"></i> ' . __("Remove Catalog") . '</a></div></div>';
            })
            ->rawColumns(['name', 'status', 'action'])
            ->toJson();
    }

    public function productscatalog()
    {
        return view('admin.product.catalog');
    }

    public function index()
    {
        return view('admin.product.index');
    }

    public function types()
    {
        return view('admin.product.types');
    }

    public function deactive()
    {
        return view('admin.product.deactive');
    }

    public function productsettings()
    {
        return view('admin.product.settings');
    }

    //*** GET Request - Updated to include tags
    public function create($slug)
    {
        $cats = Category::all();
        $brands = Brand::where('status', 1)->get();
        $tags = Tag::all(); // Fetch all tags from the tags table
        $sign = $this->curr;

        if ($slug == 'physical') {
            return view('admin.product.create.physical', compact('cats', 'sign', 'brands', 'tags'));
        } else if ($slug == 'digital') {
            return view('admin.product.create.digital', compact('cats', 'sign', 'brands', 'tags'));
        } else if ($slug == 'license') {
            return view('admin.product.create.license', compact('cats', 'sign', 'brands', 'tags'));
        } else if ($slug == 'listing') {
            return view('admin.product.create.listing', compact('cats', 'sign', 'brands', 'tags'));
        }
    }

    //*** GET Request
    public function status($id1, $id2)
    {
        $data = Product::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
    }

    //*** POST Request
    public function uploadUpdate(Request $request, $id)
    {
        // Existing uploadUpdate method remains unchanged
        $rules = ['image' => 'required'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = Product::findOrFail($id);
        $image = $request->image;
        list($type, $image) = explode(';', $image);
        list(, $image) = explode(',', $image);
        $image = base64_decode($image);
        $image_name = time() . Str::random(8) . '.png';
        $path = 'assets/images/products/' . $image_name;
        file_put_contents($path, $image);
        if ($data->photo != null && file_exists(public_path() . '/assets/images/products/' . $data->photo)) {
            unlink(public_path() . '/assets/images/products/' . $data->photo);
        }
        $input['photo'] = $image_name;
        $data->update($input);
        if ($data->thumbnail != null && file_exists(public_path() . '/assets/images/thumbnails/' . $data->thumbnail)) {
            unlink(public_path() . '/assets/images/thumbnails/' . $data->thumbnail);
        }

        $img = Image::make('assets/images/products/' . $data->photo)->resize(285, 285);
        $thumbnail = time() . Str::random(8) . '.jpg';
        $img->save('assets/images/thumbnails/' . $thumbnail);
        $data->thumbnail = $thumbnail;
        $data->update();
        return response()->json(['status' => true, 'file_name' => $image_name]);
    }

    //*** POST Request - Updated to handle tags from Blade
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'photo' => 'required',
            'file' => 'mimes:zip',
            'brand_id' => 'required',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products',
            // 'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
            'safety_information' => 'required',
            'clinical_evidences' => 'required',
            'usage_instructions' => 'required',
            'technology' => 'required',
            'tags' => 'array', // Validate tags as an array
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        //--- Logic Section
        $data = new Product;
        $sign = $this->curr;
        $input = $request->all();

        // Check File
        if ($file = $request->file('file')) {
            $name = time() . \Str::random(8) . str_replace(' ', '', $file->getClientOriginalExtension());
            $file->move('assets/files', $name);
            $input['file'] = $name;
        }

        $image = $request->photo;
        list($type, $image) = explode(';', $image);
        list(, $image) = explode(',', $image);
        $image = base64_decode($image);
        $image_name = time() . Str::random(8) . '.png';
        $path = 'assets/images/products/' . $image_name;
        file_put_contents($path, $image);
        $input['photo'] = $image_name;

        if ($request->type == "Physical" || $request->type == "Listing") {
            $rules = ['sku' => 'min:8|unique:products'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }

            $input['product_condition'] = $request->product_condition_check == "" ? 0 : $input['product_condition'];
            $input['preordered'] = $request->preordered_check == "" ? 0 : $input['preordered'];
            $input['minimum_qty'] = $request->minimum_qty_check == "" ? null : $input['minimum_qty'];
            $input['ship'] = $request->shipping_time_check == "" ? null : $input['ship'];

            if (empty($request->stock_check)) {
                $input['stock_check'] = 0;
                $input['size'] = null;
                $input['size_qty'] = null;
                $input['size_price'] = null;
            } else {
                if (in_array(null, $request->size) || in_array(null, $request->size_qty) || in_array(null, $request->size_price)) {
                    $input['stock_check'] = 0;
                    $input['size'] = null;
                    $input['size_qty'] = null;
                    $input['size_price'] = null;
                } else {
                    $input['stock_check'] = 1;
                    $input['size'] = implode(',', $request->size);
                    $input['size_qty'] = implode(',', $request->size_qty);
                    $size_prices = $request->size_price;
                    $s_price = array();
                    foreach ($size_prices as $key => $sPrice) {
                        $s_price[$key] = $sPrice / $sign->value;
                    }
                    $input['size_price'] = implode(',', $s_price);
                }
            }

            if (empty($request->color_check)) {
                $input['color_all'] = null;
                $input['color_price'] = null;
            } else {
                $input['color_all'] = implode(',', $request->color_all);
            }

            if (empty($request->whole_check)) {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            } else {
                if (!is_array($request->whole_sell_qty) || !is_array($request->whole_sell_discount) || in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount)) {
                    $input['whole_sell_qty'] = null;
                    $input['whole_sell_discount'] = null;
                } else {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }

            $input['measure'] = $request->measure_check == "" ? null : $input['measure'];
        }

        $input['meta_tag'] = empty($request->seo_check) || empty($request->meta_tag) ? null : implode(',', $request->meta_tag);
        $input['meta_description'] = empty($request->seo_check) ? null : $input['meta_description'];

        if ($request->type == "License") {
            if (!is_array($request->license) || !is_array($request->license_qty) || in_array(null, $request->license) || in_array(null, $request->license_qty)) {
                $input['license'] = null;
                $input['license_qty'] = null;
            } else {
                $input['license'] = implode(',,', $request->license);
                $input['license_qty'] = implode(',', $request->license_qty);
            }
        }

        if (!is_array($request->features) || !is_array($request->colors) || in_array(null, $request->features) || in_array(null, $request->colors)) {
            $input['features'] = null;
            $input['colors'] = null;
        } else {
            $input['features'] = implode(',', str_replace(',', ' ', $request->features));
            $input['colors'] = implode(',', str_replace(',', ' ', $request->colors));
        }

        // Handle tags from the multi-select dropdown
        if ($request->has('tags') && !empty($request->tags)) {
            $input['tags'] = implode(',', $request->tags);
        } else {
            $input['tags'] = null;
        }

        $input['price'] = ($input['price'] / $sign->value);
        $input['previous_price'] = ($input['previous_price'] ?? 0 / $sign->value);
        if ($request->cross_products) {
            $input['cross_products'] = implode(',', $request->cross_products);
        }

        $attrArr = [];
        if (!empty($request->category_id)) {
            $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
            if (!empty($catAttrs)) {
                foreach ($catAttrs as $key => $catAttr) {
                    $in_name = $catAttr->input_name;
                    if ($request->has("$in_name")) {
                        $attrArr["$in_name"]["values"] = $request["$in_name"];
                        foreach ($request["$in_name" . "_price"] as $aprice) {
                            $ttt["$in_name" . "_price"][] = $aprice / $sign->value;
                        }
                        $attrArr["$in_name"]["prices"] = $ttt["$in_name" . "_price"];
                        $attrArr["$in_name"]["details_status"] = $catAttr->details_status ? 1 : 0;
                    }
                }
            }
        }

        if (!empty($request->subcategory_id)) {
            $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
            if (!empty($subAttrs)) {
                foreach ($subAttrs as $key => $subAttr) {
                    $in_name = $subAttr->input_name;
                    if ($request->has("$in_name")) {
                        $attrArr["$in_name"]["values"] = $request["$in_name"];
                        foreach ($request["$in_name" . "_price"] as $aprice) {
                            $ttt["$in_name" . "_price"][] = $aprice / $sign->value;
                        }
                        $attrArr["$in_name"]["prices"] = $ttt["$in_name" . "_price"];
                        $attrArr["$in_name"]["details_status"] = $subAttr->details_status ? 1 : 0;
                    }
                }
            }
        }

        if (!empty($request->childcategory_id)) {
            $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
            if (!empty($childAttrs)) {
                foreach ($childAttrs as $key => $childAttr) {
                    $in_name = $childAttr->input_name;
                    if ($request->has("$in_name")) {
                        $attrArr["$in_name"]["values"] = $request["$in_name"];
                        foreach ($request["$in_name" . "_price"] as $aprice) {
                            $ttt["$in_name" . "_price"][] = $aprice / $sign->value;
                        }
                        $attrArr["$in_name"]["prices"] = $ttt["$in_name" . "_price"];
                        $attrArr["$in_name"]["details_status"] = $childAttr->details_status ? 1 : 0;
                    }
                }
            }
        }

        $input['attributes'] = empty($attrArr) ? null : json_encode($attrArr);

        // Additional fields from your Blade template
        $input['description'] = $request->description;
        $input['safety_information'] = $request->safety_information;
        $input['clinical_evidences'] = $request->clinical_evidences;
        $input['usage_instructions'] = $request->usage_instructions;
        $input['technology'] = $request->technology;
        $input['ingredients'] = $request->ingredients ?? $input['details']; // Assuming ingredients might be in details

        $data->fill($input)->save();

        $prod = Product::find($data->id);
        if ($prod->type != 'Physical' || $request->type != "Listing") {
            $prod->slug = Str::slug($data->name, '-') . '-' . strtolower(Str::random(3) . $data->id . Str::random(3));
        } else {
            $prod->slug = Str::slug($data->name, '-') . '-' . strtolower($data->sku);
        }

        $img = Image::make('assets/images/products/' . $prod->photo)->resize(285, 285);
        $thumbnail = time() . Str::random(8) . '.jpg';
        $img->save('assets/images/thumbnails/' . $thumbnail);
        $prod->thumbnail = $thumbnail;
        $prod->update();

        $lastid = $data->id;
        if ($files = $request->file('gallery')) {
            foreach ($files as $key => $file) {
                if (in_array($key, $request->galval)) {
                    $gallery = new Gallery;
                    $name = time() . \Str::random(8) . str_replace(' ', '', $file->getClientOriginalExtension());
                    $file->move('assets/images/galleries', $name);
                    $gallery['photo'] = $name;
                    $gallery['product_id'] = $lastid;
                    $gallery->save();
                }
            }
        }

        $msg = __("New Product Added Successfully.") . '<a href="' . route('admin-prod-index') . '">' . __("View Product Lists.") . '</a>';
        return response()->json($msg);
    }

    // Other methods remain unchanged below...

    public function import()
    {
        $cats = Category::all();
        $sign = $this->curr;
        return view('admin.product.productcsv', compact('cats', 'sign'));
    }

    public function importSubmit(Request $request)
    {
        // Existing importSubmit method remains unchanged
        $log = "";
        $rules = ['csvfile' => 'required|mimes:csv,txt'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $filename = '';
        if ($file = $request->file('csvfile')) {
            $filename = time() . '-' . $file->getClientOriginalExtension();
            $file->move('assets/temp_files', $filename);
        }

        $file = fopen(public_path('assets/temp_files/' . $filename), "r");
        $i = 1;

        while (($line = fgetcsv($file)) !== false) {
            if ($i != 1) {
                if (!Product::where('sku', $line[0])->exists()) {
                    $data = new Product;
                    $sign = Currency::where('is_default', '=', 1)->first();
                    $input['type'] = 'Physical';
                    $input['sku'] = $line[0];
                    $input['category_id'] = null;
                    $input['subcategory_id'] = null;
                    $input['childcategory_id'] = null;

                    $mcat = Category::where(DB::raw('lower(name)'), strtolower($line[1]));
                    if ($mcat->exists()) {
                        $input['category_id'] = $mcat->first()->id;
                        if ($line[2] != "") {
                            $scat = Subcategory::where(DB::raw('lower(name)'), strtolower($line[2]));
                            if ($scat->exists()) {
                                $input['subcategory_id'] = $scat->first()->id;
                            }
                        }
                        if ($line[3] != "") {
                            $chcat = Childcategory::where(DB::raw('lower(name)'), strtolower($line[3]));
                            if ($chcat->exists()) {
                                $input['childcategory_id'] = $chcat->first()->id;
                            }
                        }

                        $input['photo'] = $line[5];
                        $input['name'] = $line[4];
                        $input['details'] = $line[6];
                        $input['color'] = $line[13];
                        $input['price'] = $line[7];
                        $input['previous_price'] = $line[8] != "" ? $line[8] : null;
                        $input['stock'] = $line[9];
                        $input['size'] = $line[10];
                        $input['size_qty'] = $line[11];
                        $input['size_price'] = $line[12];
                        $input['youtube'] = $line[15];
                        $input['policy'] = $line[16];
                        $input['meta_tag'] = $line[17];
                        $input['meta_description'] = $line[18];
                        $input['tags'] = $line[14];
                        $input['product_type'] = $line[19];
                        $input['affiliate_link'] = $line[20];
                        $input['slug'] = Str::slug($input['name'], '-') . '-' . strtolower($input['sku']);

                        $image_url = $line[5];
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_URL, $image_url);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
                        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_HEADER, true);
                        curl_setopt($ch, CURLOPT_NOBODY, true);
                        $content = curl_exec($ch);
                        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

                        $thumb_url = '';
                        if (strpos($contentType, 'image/') !== false) {
                            $fimg = Image::make($line[5])->resize(800, 800);
                            $fphoto = time() . Str::random(8) . '.jpg';
                            $fimg->save(public_path() . '/assets/images/products/' . $fphoto);
                            $input['photo'] = $fphoto;
                            $thumb_url = $line[5];
                        } else {
                            $fimg = Image::make(public_path() . '/assets/images/noimage.png')->resize(800, 800);
                            $fphoto = time() . Str::random(8) . '.jpg';
                            $fimg->save(public_path() . '/assets/images/products/' . $fphoto);
                            $input['photo'] = $fphoto;
                            $thumb_url = public_path() . '/assets/images/noimage.png';
                        }

                        $timg = Image::make($thumb_url)->resize(285, 285);
                        $thumbnail = time() . Str::random(8) . '.jpg';
                        $timg->save(public_path() . '/assets/images/thumbnails/' . $thumbnail);
                        $input['thumbnail'] = $thumbnail;

                        $input['price'] = ($input['price'] / $sign->value);
                        $input['previous_price'] = ($input['previous_price'] ?? 0 / $sign->value);

                        $data->fill($input)->save();
                    } else {
                        $log .= "<br>" . __('Row No') . ": " . $i . " - " . __('No Category Found!') . "<br>";
                    }
                } else {
                    $log .= "<br>" . __('Row No') . ": " . $i . " - " . __('Duplicate Product Code!') . "<br>";
                }
            }
            $i++;
        }
        fclose($file);

        $msg = __('Bulk Product File Imported Successfully.') . $log;
        return response()->json($msg);
    }

    public function edit($id)
    {
        // Existing edit method updated to include tags
        $cats = Category::all();
        $data = Product::findOrFail($id);
        $brands = Brand::where('status', 1)->get();
        $tags = Tag::all();
        $sign = $this->curr;

        if ($data->type == 'Digital') {
            return view('admin.product.edit.digital', compact('cats', 'data', 'sign', 'brands', 'tags'));
        } elseif ($data->type == 'License') {
            return view('admin.product.edit.license', compact('cats', 'data', 'sign', 'brands', 'tags'));
        } elseif ($data->type == 'Listing') {
            return view('admin.product.edit.listing', compact('cats', 'data', 'sign', 'brands', 'tags'));
        } else {
            return view('admin.product.edit.physical', compact('cats', 'data', 'sign', 'brands', 'tags'));
        }
    }

    public function update(Request $request, $id)
    {
        // Existing update method remains largely unchanged, with tags handling already present
        $rules = ['file' => 'mimes:zip', 'brand_id' => 'required'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = Product::findOrFail($id);
        $sign = $this->curr;
        $input = $request->all();

        if ($request->type_check == 1) {
            $input['link'] = null;
        } else {
            if ($data->file != null && file_exists(public_path() . '/assets/files/' . $data->file)) {
                unlink(public_path() . '/assets/files/' . $data->file);
            }
            $input['file'] = null;
        }

        if ($data->type == "Physical" || $data->type == "Listing") {
            $rules = ['sku' => 'min:8|unique:products,sku,' . $id];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }

            $input['product_condition'] = $request->product_condition_check == "" ? 0 : $input['product_condition'];
            $input['preordered'] = $request->preordered_check == "" ? 0 : $input['preordered'];
            $input['minimum_qty'] = $request->minimum_qty_check == "" ? null : $input['minimum_qty'];
            $input['ship'] = $request->shipping_time_check == "" ? null : $input['ship'];

            if (empty($request->stock_check)) {
                $input['stock_check'] = 0;
                $input['size'] = null;
                $input['size_qty'] = null;
                $input['size_price'] = null;
            } else {
                if (in_array(null, $request->size) || in_array(null, $request->size_qty) || in_array(null, $request->size_price)) {
                    $input['stock_check'] = 0;
                    $input['size'] = null;
                    $input['size_qty'] = null;
                    $input['size_price'] = null;
                } else {
                    $input['stock_check'] = 1;
                    $input['size'] = implode(',', $request->size);
                    $input['size_qty'] = implode(',', $request->size_qty);
                    $size_prices = $request->size_price;
                    $s_price = array();
                    foreach ($size_prices as $key => $sPrice) {
                        $s_price[$key] = $sPrice / $sign->value;
                    }
                    $input['size_price'] = implode(',', $s_price);
                }
            }

            if (empty($request->color_check)) {
                $input['color_all'] = null;
            } else {
                $input['color_all'] = implode(',', $request->color_all);
            }

            if (empty($request->whole_check)) {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            } else {
                if (!is_array($request->whole_sell_qty) || !is_array($request->whole_sell_discount) || in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount)) {
                    $input['whole_sell_qty'] = null;
                    $input['whole_sell_discount'] = null;
                } else {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }

            $input['measure'] = $request->measure_check == "" ? null : $input['measure'];
        }

        $input['meta_tag'] = empty($request->seo_check) || empty($request->meta_tag) ? null : implode(',', $request->meta_tag);
        $input['meta_description'] = empty($request->seo_check) ? null : $input['meta_description'];

        if ($data->type == "License") {
            if (!in_array(null, $request->license) && !in_array(null, $request->license_qty)) {
                $input['license'] = implode(',,', $request->license);
                $input['license_qty'] = implode(',', $request->license_qty);
            } else {
                if (!is_array($request->license) || !is_array($request->license_qty) || in_array(null, $request->license) || in_array(null, $request->license_qty)) {
                    $input['license'] = null;
                    $input['license_qty'] = null;
                } else {
                    $license = explode(',,', $data->license);
                    $license_qty = explode(',', $data->license_qty);
                    $input['license'] = implode(',,', $license);
                    $input['license_qty'] = implode(',', $license_qty);
                }
            }
        }

        if (!in_array(null, $request->features) && !in_array(null, $request->colors)) {
            $input['features'] = implode(',', str_replace(',', ' ', $request->features));
            $input['colors'] = implode(',', str_replace(',', ' ', $request->colors));
        } else {
            if (!is_array($request->features) || !is_array($request->colors) || in_array(null, $request->features) || in_array(null, $request->colors)) {
                $input['features'] = null;
                $input['colors'] = null;
            } else {
                $features = explode(',', $data->features);
                $colors = explode(',', $data->colors);
                $input['features'] = implode(',', $features);
                $input['colors'] = implode(',', $colors);
            }
        }

        if ($request->has('tags') && !empty($request->tags)) {
            $input['tags'] = implode(',', $request->tags);
        } else {
            $input['tags'] = null;
        }

        $input['price'] = $input['price'] / $sign->value;
        $input['previous_price'] = $input['previous_price'] ?? 0 / $sign->value;

        $attrArr = [];
        if (!empty($request->category_id)) {
            $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
            if (!empty($catAttrs)) {
                foreach ($catAttrs as $key => $catAttr) {
                    $in_name = $catAttr->input_name;
                    if ($request->has("$in_name")) {
                        $attrArr["$in_name"]["values"] = $request["$in_name"];
                        foreach ($request["$in_name" . "_price"] as $aprice) {
                            $ttt["$in_name" . "_price"][] = $aprice / $sign->value;
                        }
                        $attrArr["$in_name"]["prices"] = $ttt["$in_name" . "_price"];
                        $attrArr["$in_name"]["details_status"] = $catAttr->details_status ? 1 : 0;
                    }
                }
            }
        }

        if (!empty($request->subcategory_id)) {
            $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
            if (!empty($subAttrs)) {
                foreach ($subAttrs as $key => $subAttr) {
                    $in_name = $subAttr->input_name;
                    if ($request->has("$in_name")) {
                        $attrArr["$in_name"]["values"] = $request["$in_name"];
                        foreach ($request["$in_name" . "_price"] as $aprice) {
                            $ttt["$in_name" . "_price"][] = $aprice / $sign->value;
                        }
                        $attrArr["$in_name"]["prices"] = $ttt["$in_name" . "_price"];
                        $attrArr["$in_name"]["details_status"] = $subAttr->details_status ? 1 : 0;
                    }
                }
            }
        }

        if (!empty($request->childcategory_id)) {
            $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
            if (!empty($childAttrs)) {
                foreach ($childAttrs as $key => $childAttr) {
                    $in_name = $childAttr->input_name;
                    if ($request->has("$in_name")) {
                        $attrArr["$in_name"]["values"] = $request["$in_name"];
                        foreach ($request["$in_name" . "_price"] as $aprice) {
                            $ttt["$in_name" . "_price"][] = $aprice / $sign->value;
                        }
                        $attrArr["$in_name"]["prices"] = $ttt["$in_name" . "_price"];
                        $attrArr["$in_name"]["details_status"] = $childAttr->details_status ? 1 : 0;
                    }
                }
            }
        }

        $input['attributes'] = empty($attrArr) ? null : json_encode($attrArr);
        if ($request->cross_products) {
            $input['cross_products'] = implode(',', $request->cross_products);
        }
        $data->slug = Str::slug($data->name, '-') . '-' . strtolower($data->sku);

        $input['description'] = $request->filled('description') ? $request->description : $data->description;
        $input['safety_information'] = $request->filled('safety_information') ? $request->safety_information : $data->safety_information;
        $input['clinical_evidences'] = $request->filled('clinical_evidences') ? $request->clinical_evidences : $data->clinical_evidences;
        $input['usage_instructions'] = $request->filled('usage_instructions') ? $request->usage_instructions : $data->usage_instructions;
        $input['technology'] = $request->filled('technology') ? $request->technology : $data->technology;
        $input['ingredients'] = $request->filled('ingredients') ? $request->ingredients : $data->ingredients;

        $data->update($input);

        $msg = __("Product Updated Successfully.") . '<a href="' . route('admin-prod-index') . '">' . __("View Product Lists.") . '</a>';
        return response()->json($msg);
    }

    public function feature($id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.highlight', compact('data'));
    }

    public function featuresubmit(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $input = $request->all();
        $input['featured'] = $request->featured == "" ? 0 : $input['featured'];
        $input['hot'] = $request->hot == "" ? 0 : $input['hot'];
        $input['best'] = $request->best == "" ? 0 : $input['best'];
        $input['top'] = $request->top == "" ? 0 : $input['top'];
        $input['latest'] = $request->latest == "" ? 0 : $input['latest'];
        $input['big'] = $request->big == "" ? 0 : $input['big'];
        $input['trending'] = $request->trending == "" ? 0 : $input['trending'];
        $input['sale'] = $request->sale == "" ? 0 : $input['sale'];
        $input['is_discount'] = $request->is_discount == "" ? 0 : $input['is_discount'];
        $input['discount_date'] = $request->is_discount == "" ? null : \Carbon\Carbon::parse($input['discount_date'])->format('Y-m-d');

        $data->update($input);
        $msg = __('Highlight Updated Successfully.');
        return response()->json($msg);
    }

    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        if ($data->galleries->count() > 0) {
            foreach ($data->galleries as $gal) {
                if (file_exists(public_path() . '/assets/images/galleries/' . $gal->photo)) {
                    unlink(public_path() . '/assets/images/galleries/' . $gal->photo);
                }
                $gal->delete();
            }
        }

        if ($data->reports->count() > 0) {
            foreach ($data->reports as $gal) {
                $gal->delete();
            }
        }

        if ($data->ratings->count() > 0) {
            foreach ($data->ratings as $gal) {
                $gal->delete();
            }
        }
        if ($data->wishlists->count() > 0) {
            foreach ($data->wishlists as $gal) {
                $gal->delete();
            }
        }
        if ($data->clicks->count() > 0) {
            foreach ($data->clicks as $gal) {
                $gal->delete();
            }
        }
        if ($data->comments->count() > 0) {
            foreach ($data->comments as $gal) {
                if ($gal->replies->count() > 0) {
                    foreach ($gal->replies as $key) {
                        $key->delete();
                    }
                }
                $gal->delete();
            }
        }

        if (!filter_var($data->photo, FILTER_VALIDATE_URL) && file_exists(public_path() . '/assets/images/products/' . $data->photo)) {
            unlink(public_path() . '/assets/images/products/' . $data->photo);
        }

        if (file_exists(public_path() . '/assets/images/thumbnails/' . $data->thumbnail) && $data->thumbnail != "") {
            unlink(public_path() . '/assets/images/thumbnails/' . $data->thumbnail);
        }

        if ($data->file != null && file_exists(public_path() . '/assets/files/' . $data->file)) {
            unlink(public_path() . '/assets/files/' . $data->file);
        }
        $data->delete();

        $msg = __('Product Deleted Successfully.');
        return response()->json($msg);
    }

    public function catalog($id1, $id2)
    {
        $data = Product::findOrFail($id1);
        $data->is_catalog = $id2;
        $data->update();
        $msg = $id2 == 1 ? "Product added to catalog successfully." : "Product removed from catalog successfully.";
        return response()->json($msg);
    }

    public function settingUpdate(Request $request)
    {
        $input = $request->all();
        $data = \App\Models\Generalsetting::findOrFail(1);
        $input['product_page'] = !empty($request->product_page) ? implode(',', $request->product_page) : null;
        $input['wishlist_page'] = !empty($request->wishlist_page) ? implode(',', $request->wishlist_page) : null;
        cache()->forget('generalsettings');
        $data->update($input);
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);
    }

    public function getAttributes(Request $request)
    {
        $model = '';
        if ($request->type == 'category') {
            $model = 'App\Models\Category';
        } elseif ($request->type == 'subcategory') {
            $model = 'App\Models\Subcategory';
        } elseif ($request->type == 'childcategory') {
            $model = 'App\Models\Childcategory';
        }

        $attributes = Attribute::where('attributable_id', $request->id)->where('attributable_type', $model)->get();
        $attrOptions = [];
        foreach ($attributes as $key => $attribute) {
            $options = AttributeOption::where('attribute_id', $attribute->id)->get();
            $attrOptions[] = ['attribute' => $attribute, 'options' => $options];
        }
        return response()->json($attrOptions);
    }

    public function getCrossProduct($catId)
    {
        $crossProducts = Product::where('category_id', $catId)->where('status', 1)->get();
        return view('load.cross_product', compact('crossProducts'));
    }
}
