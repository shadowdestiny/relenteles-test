<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Http\Resources\FavoriteResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
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

    public function getAll()
    {

            $rate = Rate::all()
                ->get();

            return $rate;
    }

    public function getMe()
    {
        $user = Auth::user();

        $rate = Rate::where("user_id","=",$user->id)
            ->get();

        return $rate;
    }

    public function createRating(Request $request)
    {

        $this->validate($request,[
            'product_id'    => 'required|integer',
            'rate'          => 'required|integer',
            'review'        => 'required|integer',
        ]);

        if ($request->isJson()) {

            $user = Auth::user();

            $product = Product::find($request["product_id"]);

            if ($product){
                $favorite = Favorite::where("product_id","=",$request["product_id"])
                    ->where("user_id","=",$user->id)->first();

                if (!$favorite){
                    $favorite = new Favorite();
                    $favorite->product_id           = $request["product_id"];
                    $favorite->user_id              = $user->id;
                    $favorite->save();

                    return response()->json(new FavoriteResource($favorite), 201);
                } else {
                    return response()->json(['error' => 'Duplicate row'], 406, []);
                }
            } else {
                return response()->json(['error' => 'Not Found product'], 406, []);
            }

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }



}
