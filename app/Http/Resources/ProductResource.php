<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ProductResource extends JsonResource
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
        $sum = 0;
        foreach($this->rates as $rate){
            $sum += $rate->rate;
        }

        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'price'             => $this->price,
            'category_id'       => $this->category_id,
            'category'          => new CategoryResource($this->category),
            'image'             => $this->image,
            'seller'            => $this->seller,
            'rates'             => RateResource::collection($this->rates),
            'rating'            => $sum / (count($this->rates) > 0 ? count($this->rates) : 1),
        ];
    }
}
