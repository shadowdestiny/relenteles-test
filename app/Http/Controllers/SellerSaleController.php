<?php

namespace App\Http\Controllers;

use App\Car;
use App\Http\Resources\BuyerSalesResource;
use App\Http\Resources\CarResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\SellerSalesResource;
use App\Order;
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

    public function getFindBySeller($id)
    {

        $user = Auth::user();

        $seller_sale = SellerSale::where("seller_id","=",$user->id)
            ->where('id','=',$id)
            ->first();

        if($seller_sale){
            return  response()->json(new SellerSalesResource($seller_sale), 200);
        } else {
            return response()->json(['error' => 'Not found'], 406, []);
        }

    }

    public function getByBuyer()
    {
        $user = Auth::user();

        $order = Order::where("buyer_id",$user->id)->get();

        if($order){
            return response()->json(['orders' => OrderResource::collection($order)]);
        } else {
            return response()->json(['error' => 'Not found'], 406, []);
        }

    }

    public function getFindByBuyer($id)
    {
        $user = Auth::user();

        $order = Order::where("buyer_id",$user->id)
            ->where('id','=',$id)
            ->first();


        if($order){
            return  response()->json(new OrderResource($order), 200);
        } else {
            return response()->json(['error' => 'Not found'], 406, []);
        }

    }

}
