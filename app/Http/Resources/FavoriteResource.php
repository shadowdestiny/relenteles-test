<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Stripe\Collection;

class FavoriteResource extends JsonResource
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
            'product_id'        => $this->product_id,
            'user_id'           => $this->user_id,
            'product'           => new ProductResource($this->products),
        ];
    }
}
