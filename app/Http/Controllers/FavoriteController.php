<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Http\Resources\FavoriteResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
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
            $user = Auth::user();

            $favorite = Favorite::where("user_id","=",$user->id)
                ->get();

            return FavoriteResource::collection($favorite);
    }

    public function createFavorite(Request $request)
    {

        $this->validate($request,[
            'product_id' => 'required|integer',
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

    public function deleteFavorite($id)
    {

            try {

                $user = Auth::user();

                $favorite = Favorite::where('id','=',$id)
                    ->where('user_id','=',$user->id)->first();
                ;

                if ($favorite){
                    $favorite->delete();
                    return response()->json($favorite, 200);
                } else {
                    return response()->json(['error' => 'Not found'], 406);
                }

            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }

    }

}
