<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Cashier\Billable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
    use Billable;

    const SELLER    = 1;
    const BUYER     = 2;

    // states
    const STATES = [
        "NOT_SENT"      => 0,
        "ON_THE_WAY"    => 1,
        "DELIVERED"     => 2,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'api_token',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zipcode',
        'type_user',
        'youtube_url',
        'spotify_url',
        'podcast_url',
        'itunes_url',
        'image',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'api_token',
        'remember_token',
        "stripe_id",
        "card_brand",
        "card_last_four",
        "trial_ends_at"
    ];
}
