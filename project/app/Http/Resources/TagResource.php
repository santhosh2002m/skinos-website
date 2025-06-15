<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
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
        'name' => $this->name,
        'slug' => $this->slug,
        'icon' => url('/') . '/assets/images/categories/'.$this->image,
        'image' => $this->when($this->image, url('/') . '/assets/images/categories/'.$this->image),
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
      ];
    }
}
