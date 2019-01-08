<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class SellerSale extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'seller_id',
        'number_order',
        'number_tracking',
        'shipping_status',
        'shipping_address',
        'shipping_city',
        'shipping_zipcode',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    // states
    const STATES = [
        "NOT_SENT"      => 0,
        "ON_THE_WAY"    => 1,
        "DELIVERED"     => 2,
    ];

    public function buyer(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function seller(){
        return $this->hasOne(User::class,'id','seller_id');
    }

    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
