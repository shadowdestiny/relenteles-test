<?php

namespace App\Http\Controllers;

use App\Favorite;
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

    public function getAll(Request $request)
    {
        if ($request->isJson()) {

            $user = Auth::user();

            return Favorite::where("user_id","=",$user->id)
                ->get();
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function createFavorite(Request $request)
    {

        $this->validate($request,[
            'product_id' => 'required|integer',
        ]);

        if ($request->isJson()) {

            $user = Auth::user();

            $data = $request->json()->all();

            $product = Product::find($data['product_id']);

            if ($product){
                $category = new Favorite();
                $category->product_id           = $product->id;
                $category->user_id              = $user->id;
                $category->save();

                return response()->json($category, 201);
            } else {
                return response()->json(['error' => 'Not found'], 401, []);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function deleteFavorite(Request $request, $id)
    {
        if ($request->isJson()) {

            try {
                $category = Favorite::findOrFail($id);
                $category->delete();

                return response()->json($category, 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

}
