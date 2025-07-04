<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\RatingResource;
use App\Http\Resources\CommentResource;
use App\Models\Admin;
use App\Models\Product;

class ProductDetailsResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'user_id' => $this->user_id,
      'title' => $this->name,
      'type' => $this->type,
      'attributes' => $this->attributes ? json_decode($this->attributes, true) : null,
      'thumbnail' => url('/') . '/assets/images/thumbnails/' . $this->thumbnail,
      'first_image' => url('/') . '/assets/images/products/' . $this->photo,
      'images' => GalleryResource::collection($this->galleries),
      'rating' =>  $this->ratings()->avg('rating') > 0 ? (string) round($this->ratings()->avg('rating'), 2) : (string) round(0.00, 2),
      'current_price' => (string)$this->ApishowPrice(),
      'description' => $this->descrtipton,
      'clinical_evidences' => $this->clinical_evidences,
      'usage_instructions' => $this->usage_instructions,
      'technology' => $this->technology,
      'ingredients' => $this->ingredients,
      'is_wishlisted' => $this->is_wishlisted ?? false,
      'previous_price' => (string)$this->ApishowPreviousPrice(),
      'stock' => $this->stock,
      'brand' => $this->brand,
      'condition' => $this->when($this->product_condition != 0, function () {
        if ($this->product_condition == 2) {
          return 'New';
        } else {
          return 'Used';
        }
      }),
      'video' => $this->youtube,
      'stock_check' => $this->stock_check,
      'estimated_shipping_time' => $this->ship,
      'colors' => $this->color,
      'sizes' => $this->size,
      'size_quantity' => $this->size_qty,
      'size_price' => $this->size_price,
      'details' => strip_tags($this->details),
      'policy' => strip_tags($this->policy),
      'whole_sell_quantity' => $this->whole_sell_qty,
      'whole_sell_discount' => $this->whole_sell_discount,
      'reviews' => RatingResource::collection($this->ratings),
      'comments' => CommentResource::collection($this->comments),
      'related_products' => ProductlistResource::collection($this->category->products()->where('status', '=', 1)->where('id', '!=', $this->id)->take(8)->get()),
      'shop' => [
        'name' => $this->user_id  != 0 ? $this->user->shop_name : Admin::first()->shop_name,
        'items' => $this->when(true, function () {
          if ($this->user_id  != 0) {
            return Product::where('user_id', '=', $this->user_id)->get()->count() . ' items';
          } else {
            return Product::where('user_id', '=', 0)->get()->count() . ' items';
          }
        }),
      ],
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}
