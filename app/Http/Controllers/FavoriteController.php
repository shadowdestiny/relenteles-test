<?php

namespace App\Http\Controllers;

use App\Favorite;
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

            return Favorite::where("user_id","=",$user->id)
                ->get();
    }

    public function createFavorite(Request $request)
    {

        $this->validate($request,[
            'product_id' => 'required|integer',
        ]);

        if ($request->isJson()) {

            $user = Auth::user();

            $favorite = Favorite::where("product_id","=",$request["product_id"])
                ->where("user_id","=",$user->id)->get();

            if (!$favorite){
                $favorite = new Favorite();
                $favorite->product_id           = $request["product_id"];
                $favorite->user_id              = $user->id;
                $favorite->save();
                return response()->json($favorite, 201);
            } else {
                return response()->json(['error' => 'Duplicate row or not found'], 401, []);
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
