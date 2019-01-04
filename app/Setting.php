<?php

namespace App;

use App\Http\Resources\SettingBuyerResource;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Setting extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'description',
        'type',
        'order',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    // types
    const TYPE_NOTIFICATION_SELLER  = 'notification_seller';
    const TYPE_NOTIFICATION_BUYER   = 'notification_buyer';

    public function setting_seller(){
        return $this->hasMany(SettingForSeller::class,'setting_id','id');
    }

    public function setting_buyer(){
        return $this->hasMany(SettingForBuyer::class,'setting_id','id');
    }
}
