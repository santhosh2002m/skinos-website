<?php

namespace App\Http\Controllers\User;

use App\Models\Blog;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WishlistController extends UserBaseController
{
    public function wishlists(Request $request)
    {
        try {
            $gs = $this->gs ?? (object) ['wishlist_count' => 10, 'breadcrumb_banner' => null];
            $sort = $request->input('sort', '');
            $pageby = $request->input('pageby', $gs->wishlist_count);
            $user = $this->user;

            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            // Fetch wishlist entries with product data
            $wishlists = Wishlist::join('products', 'wishlists.product_id', '=', 'products.id')
                ->where('wishlists.user_id', $user->id)
                ->where('products.status', 1)
                ->select(
                    'products.*',
                    'wishlists.id as wishlist_id'
                );

            // Apply sorting
            switch ($sort) {
                case 'id_asc':
                    $wishlists->orderBy('wishlists.id', 'asc');
                    break;
                case 'price_asc':
                    $wishlists->orderBy('products.price', 'asc');
                    break;
                case 'price_desc':
                    $wishlists->orderBy('products.price', 'desc');
                    break;
                case 'id_desc':
                default:
                    $wishlists->orderBy('wishlists.id', 'desc');
                    break;
            }

            $wishlists = $wishlists->paginate($pageby);

            // Fetch footer blogs
            $footer_blogs = Blog::where('status', 1)->take(3)->get();

            if ($request->ajax()) {
                return view('front.ajax.wishlist', compact('user', 'wishlists', 'sort', 'pageby', 'footer_blogs'));
            }

            return view('user.wishlist', compact('user', 'wishlists', 'sort', 'pageby', 'footer_blogs'));
        } catch (\Exception $e) {
            Log::error('WishlistController::wishlists failed: ' . $e->getMessage(), ['user_id' => $this->user?->id]);
            return response()->view('errors.500', [], 500);
        }
    }

    public function addwish($id)
    {
        try {
            $user = $this->user;
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            $product = Product::findOrFail($id);
            if ($product->status != 1) {
                throw new \Exception('Product is not active');
            }

            $exists = Wishlist::where('user_id', $user->id)->where('product_id', $id)->exists();
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => __('Already Added To The Wishlist.')
                ], 422);
            }

            $wish = new Wishlist();
            $wish->user_id = $user->id;
            $wish->product_id = $id;
            $wish->save();

            return response()->json([
                'success' => true,
                'wishlist_id' => $wish->id,
                'count' => Wishlist::where('user_id', $user->id)->count(),
                'message' => __('Successfully Added To The Wishlist.')
            ]);
        } catch (\Exception $e) {
            Log::error('WishlistController::addwish failed: ' . $e->getMessage(), ['user_id' => $this->user?->id, 'product_id' => $id]);
            return response()->json([
                'success' => false,
                'message' => __('Failed to add to wishlist: ') . $e->getMessage()
            ], 500);
        }
    }

    public function removewish($id)
    {
        try {
            $user = $this->user;
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            $wish = Wishlist::where('user_id', $user->id)->where('id', $id)->firstOrFail();
            $wish->delete();

            return response()->json([
                'success' => true,
                'count' => Wishlist::where('user_id', $user->id)->count(),
                'message' => __('Successfully Removed From Wishlist.')
            ]);
        } catch (\Exception $e) {
            Log::error('WishlistController::removewish failed: ' . $e->getMessage(), ['user_id' => $this->user?->id, 'wishlist_id' => $id]);
            return response()->json([
                'success' => false,
                'message' => __('Failed to remove from wishlist.')
            ], 500);
        }
    }
}