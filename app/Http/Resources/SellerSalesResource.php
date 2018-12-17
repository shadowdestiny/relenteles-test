<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerSalesResource extends JsonResource
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
            'id'                    => $this->id,
            'shipping_status'       => $this->shipping_status,
            'num_order'             => $this->number_order,
            'product'               => $this->product,
            'buyer'                 => $this->buyer,
            'seller'                => $this->seller,
        ];
    }
}
