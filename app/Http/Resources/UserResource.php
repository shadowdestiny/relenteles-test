<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'email'             => $this->email,
            'shipping_address'  => $this->shipping_address,
            'shipping_city'     => $this->shipping_city,
            'shipping_state'    => $this->shipping_state,
            'shipping_zipcode'  => $this->shipping_zipcode,
            'api_token'         => $this->api_token,
        ];
    }
}