<?php

namespace App\Http\Controllers\Front;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\DiscountSlab;
use App\Models\Product;
use App\Models\Report;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;

class CatalogController extends FrontBaseController
{

    // CATEGORIES SECTOPN

    public function categories()
    {
        $categories = Category::where('status', 1)->get();
        return view('frontend.products', compact('categories'));
    }

    // -------------------------------- CATEGORY SECTION ----------------------------------------

    public function category(Request $request, $slug = null, $slug1 = null, $slug2 = null, $slug3 = null)
    {
        $user = Auth::user();
        $user_type = $user->preferred_type ?? null;
        if ($user_type == 'net_discount_profile') {
            $discountSlab = DiscountSlab::where('status', 1)->get();
            $data['discountSlab'] = $discountSlab;
        }
        $data['categories'] = Category::where('status', 1)->get();
        $data['brands'] = Brand::where('status', 1)->get();

        if ($request->view_check) {
            session::put('view', $request->view_check);
        }

        //   dd(session::get('view'));

        $cat = null;
        $subcat = null;
        $childcat = null;
        $flash = null;
        $minprice = $request->min;
        $maxprice = $request->max;
        $sort = $request->sort;
        $search = $request->search;
        $pageby = $request->pageby;
        $brand = $request->brand;
        $tag = $request->tag;
        $tags = $request->tags;

        $minprice = ($minprice / $this->curr->value);
        $maxprice = ($maxprice / $this->curr->value);
        $type = $request->has('type') ?? '';

        if (!empty($slug)) {
            $cat = Category::where('slug', $slug)->firstOrFail();
            $data['cat'] = $cat;
        }

        if (!empty($slug1)) {
            $subcat = Subcategory::where('slug', $slug1)->firstOrFail();
            $data['subcat'] = $subcat;
        }
        if (!empty($slug2)) {
            $childcat = Childcategory::where('slug', $slug2)->firstOrFail();
            $data['childcat'] = $childcat;
        }

        $data['latest_products'] = Product::with('user')->whereStatus(1)->whereLatest(1)
            ->whereHas('user', function ($q) {
                $q->where('is_vendor', 2);
            })
            ->when('user', function ($query) {
                foreach ($query as $q) {
                    if ($q->is_vendor == 2) {
                        return $q;
                    }
                }
            })
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->take(5)
            ->get();

        $prods = Product::with([
            'user',
            'brand',
            'brand.scheme',
            'brand.scheme.scheme_entries' => function ($query) {
                $query->orderBy('order');
            },
        ])
        ->when($cat, function ($query, $cat) {
            return $query->where('category_id', $cat->id);
        })
            ->when($subcat, function ($query, $subcat) {
                return $query->where('subcategory_id', $subcat->id);
            })
            ->when($brand, fn($query) => $query->whereHas('brand', fn($q) => $q->where('slug', $brand)))
            ->when($tag, fn($query) => $query->where('tags', 'like', "%$tag%"))
            ->when($tags, function ($query, $tags) {
                $tagsArray = is_array($tags) ? $tags : [$tags]; // Ensure it's always an array
                
                $query->where(function ($q) use ($tagsArray) {
                    foreach ($tagsArray as $tag) {
                        $q->orWhere('tags', 'like', "%$tag%");
                    }
                });
            })
            
            ->when($type, function ($query, $type) {
                return $query->with('user')->whereStatus(1)->whereIsDiscount(1)
                    ->where('discount_date', '>=', date('Y-m-d'))
                    ->whereHas('user', function ($user) {
                        $user->where('is_vendor', 2);
                    });
            })
            ->when($childcat, function ($query, $childcat) {
                return $query->where('childcategory_id', $childcat->id);
            })
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')->orWhere('name', 'like', $search . '%');
            })
            ->when($minprice, function ($query, $minprice) {
                return $query->where('price', '>=', $minprice);
            })
            ->when($maxprice, function ($query, $maxprice) {
                return $query->where('price', '<=', $maxprice);
            })
            ->when($sort, function ($query, $sort) {
                if ($sort == 'date_desc') {
                    return $query->latest('id');
                } elseif ($sort == 'date_asc') {
                    return $query->oldest('id');
                } elseif ($sort == 'price_desc') {
                    return $query->latest('price');
                } elseif ($sort == 'price_asc') {
                    return $query->oldest('price');
                }
            })
            ->when(empty($sort), function ($query, $sort) {
                return $query->latest('id');
            })
            ->withCount('ratings')
            ->withAvg('ratings', 'rating');

        $prods = $prods->where(function ($query) use ($cat, $subcat, $childcat, $type, $request) {
            $flag = 0;
            if (!empty($cat)) {
                foreach ($cat->attributes as $key => $attribute) {
                    $inname = $attribute->input_name;
                    $chFilters = $request["$inname"];

                    if (!empty($chFilters)) {
                        $flag = 1;
                        foreach ($chFilters as $key => $chFilter) {
                            if ($key == 0) {
                                $query->where('attributes', 'like', '%' . '"' . $chFilter . '"' . '%');
                            } else {
                                $query->orWhere('attributes', 'like', '%' . '"' . $chFilter . '"' . '%');
                            }
                        }
                    }
                }
            }

            if (!empty($subcat)) {
                foreach ($subcat->attributes as $attribute) {
                    $inname = $attribute->input_name;
                    $chFilters = $request["$inname"];

                    if (!empty($chFilters)) {
                        $flag = 1;
                        foreach ($chFilters as $key => $chFilter) {
                            if ($key == 0 && $flag == 0) {
                                $query->where('attributes', 'like', '%' . '"' . $chFilter . '"' . '%');
                            } else {
                                $query->orWhere('attributes', 'like', '%' . '"' . $chFilter . '"' . '%');
                            }
                        }
                    }
                }
            }

            if (!empty($childcat)) {
                foreach ($childcat->attributes as $attribute) {
                    $inname = $attribute->input_name;
                    $chFilters = $request["$inname"];

                    if (!empty($chFilters)) {
                        $flag = 1;
                        foreach ($chFilters as $key => $chFilter) {
                            if ($key == 0 && $flag == 0) {
                                $query->where('attributes', 'like', '%' . '"' . $chFilter . '"' . '%');
                            } else {
                                $query->orWhere('attributes', 'like', '%' . '"' . $chFilter . '"' . '%');
                            }
                        }
                    }
                }
            }
        });

        $prods = $prods->where('status', 1)->get()

            ->map(function ($item) {
                $item->price = $item->vendorSizePrice();
                return $item;
            })->paginate(isset($pageby) ? $pageby : $this->gs->page_count);
        $data['prods'] = $prods;
        if ($request->ajax()) {
            $data['ajax_check'] = 1;
            return view('frontend.ajax.category', $data);
        }

        return view('frontend.products', $data);
    }

    public function getsubs(Request $request)
    {
        $category = Category::where('slug', $request->category)->firstOrFail();
        $subcategories = Subcategory::where('category_id', $category->id)->get();
        return $subcategories;
    }
    public function report(Request $request)
    {

        //--- Validation Section
        $rules = [
            'note' => 'max:400',
        ];
        $customs = [
            'note.max' => 'Note Must Be Less Than 400 Characters.',
        ];
        
        $request->validate($rules, $customs);


        $data = new Report;
        $input = $request->all();
        $data->fill($input)->save();
        return back()->with('success', 'Report has been sent successfully.');

    }
}
