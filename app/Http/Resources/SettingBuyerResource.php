<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SettingBuyerResource extends JsonResource
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

        return [
            'id'                => $this->id,
            'code'              => $this->code,
            'description'       => $this->description,
            'checked'           => $this->setting_buyer->where("buyer_id",'=',$user->id)->first() ? true : false,
        ];
    }
}
