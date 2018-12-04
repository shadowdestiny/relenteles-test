<?php

namespace App\Http\Resources;

use App\Category;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductJoinFavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'price'             => $this->price,
            'category'          => $this->category,
            'image'             => $this->image,
            'seller'            => $this->seller,
            'is_favorite'       => $this["favorite_id"] === null ? false : true,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
