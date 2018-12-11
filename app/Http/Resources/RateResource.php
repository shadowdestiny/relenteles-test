<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class RateResource extends JsonResource
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
            'rate'              => $this->rate,
            'review'            => $this->review,
            'product_id'        => $this->product_id,
            'user_id'           => $this->user_id,
            'user'              => new UserPrivateResource($this->users),
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,

        ];
    }
}
