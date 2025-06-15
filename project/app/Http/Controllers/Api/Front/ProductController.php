<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;

use App\Http\Resources\ProductDetailsResource;
use App\Http\Resources\RatingResource;
use App\Http\Resources\ReplyResource;
use App\Models\Comment;
use App\Models\DiscountSlab;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function productDetails($id)
    {
        try {
            $user = Auth::user();
            $wishlistProductIds = $user ? $user->wishlists()->pluck('product_id')->toArray() : [];
            $user_type = $user->preferred_type ?? null;

            $discountSlabs = [];
            if ($user_type === 'net_discount_profile') {
                $discountSlabs = DiscountSlab::where('status', 1)->get();
            }

            $product = Product::with('brand')->find($id);
            if (!$product) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'error' => ['message' => 'Item not found.']
                ]);
            }
            $product->is_wishlisted = in_array($product->id, $wishlistProductIds);
            return response()->json([
                'status' => true,
                'data' => [
                    'product' => new ProductDetailsResource($product),
                    'discount_slabs' => $discountSlabs
                ],
                'error' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'data' => [],
                'error' => ['message' => $e->getMessage()]
            ]);
        }
    }
    

    public function ratings($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Item not found."]]);
            }
            $ratings = $product->ratings;

            return response()->json(['status' => true, 'data' => RatingResource::collection($ratings), 'error' => []]);
        } catch (\Exception $e) {
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    public function comments($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Item not found."]]);
            }
            $comments = $product->comments()->orderBy('id', 'DESC')->get();
            return response()->json(['status' => true, 'data' => CommentResource::collection($comments), 'error' => []]);
        } catch (\Exception $e) {
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    public function replies($id)
    {
        try {
            $comment = Comment::find($id);
            if (!$comment) {
                return response()->json(['status' => false, 'data' => [], 'error' => ["message" => "Comment not found."]]);
            }
            $replies = $comment->replies()->orderBy('id', 'DESC')->get();
            return response()->json(['status' => true, 'data' => ReplyResource::collection($replies), 'error' => []]);
        } catch (\Exception $e) {
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }
}
