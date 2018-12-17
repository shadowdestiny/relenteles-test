<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Product extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function seller(){
        return $this->belongsTo(User::class,'seller_id','id');
    }
    public function rates(){
        return $this->hasMany(Rate::class,'product_id','id');
    }
    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
        // change to
        //return $this->belongsTo(Category::class,'category_id','id');
    }
}
