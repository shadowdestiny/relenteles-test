<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingSellerResource;
use App\SettingForSeller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
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

    public function getAllSeller()
    {

            $user = Auth::user();

            $cars = SettingForSeller::where("seller_id","=",$user->id)
                ->get();

            if($cars){
                return SettingSellerResource::collection($cars);
            } else {
                return response()->json(['error' => 'Not found'], 406, []);
            }

    }

    public function getAllBuyer()
    {

        $user = Auth::user();

        $cars = SettingForSeller::where("seller_id","=",$user->id)
            ->get();

        if($cars){
            return SettingSellerResource::collection($cars);
        } else {
            return response()->json(['error' => 'Not found'], 406, []);
        }

    }

    public function createCar(Request $request)
    {

        $this->validate($request,[
            'product_id' => 'required|integer',
        ]);

        if ($request->isJson()) {

            $user = Auth::user();

            $card = Car::where("product_id","=",$request["product_id"])
                ->where("user_id","=",$user->id)
                ->first();

            if(!$card){
                $car = new Car();
                $car->product_id           = $request['product_id'];
                $car->user_id              = $user->id;
                $car->save();
                return response()->json(new CarResource($car), 201);
            } else {
                return response()->json(['error' => 'Duplicate row or not found'], 401, []);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function deleteCar( $id)
    {


            try {

                $user = Auth::user();

                $car = Car::where('id','=',$id)
                    ->where('user_id','=',$user->id)->first();
                ;

                if ($car){
                    $car->delete();
                    return response()->json(new CarResource($car), 200);
                } else {
                    return response()->json(['error' => 'Not found'], 406);
                }

            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }


    }

}
