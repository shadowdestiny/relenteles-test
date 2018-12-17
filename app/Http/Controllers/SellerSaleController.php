<?php

namespace App\Http\Controllers;

use App\Car;
use App\Http\Resources\CarResource;
use App\Http\Resources\SellerSalesResource;
use App\SellerSale;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class SellerSaleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getBySeller()
    {

            $user = Auth::user();

            $seller_sale = SellerSale::where("seller_id","=",$user->id)
                ->get();

            if($seller_sale){
                return SellerSalesResource::collection($seller_sale);
            } else {
                return response()->json(['error' => 'Not found'], 406, []);
            }

    }

    public function getByBuyer()
    {

        $user = Auth::user();

        $seller_sale = SellerSale::where("user_id","=",$user->id)
            ->get();

        if($seller_sale){
            return SellerSalesResource::collection($seller_sale);
        } else {
            return response()->json(['error' => 'Not found'], 406, []);
        }

    }

}
