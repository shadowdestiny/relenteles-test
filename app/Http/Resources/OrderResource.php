<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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

        $products = [];
        if(isset($this->seller_sales))
            foreach ($this->seller_sales as $seller_sale){
                array_push($products, new ProductResource($seller_sale->product));
            }

        return [

            'products'  => $products,

        ];
    }
}
