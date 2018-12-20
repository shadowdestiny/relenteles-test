<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        $sum = 0;
        foreach($this->rates as $rate){
            $sum += $rate->rate;
        }

        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'price'             => $this->price,
            'category'          => $this->category,
            'image'             => $this->image,
            'seller'            => $this->seller,
            'rate'              => $this->rates->where("user_id","=",$user->id)->first(),
            'rates'             => RateResource::collection($this->rates),
            'rating'            => $sum / (count($this->rates) > 0 ? count($this->rates) : 1),
            'is_favorite'       => $this["favorite_id"] === null ? false : true,
            'favorite_id'       => $this["favorite_id"],
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
