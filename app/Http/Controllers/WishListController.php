<?php

namespace App\Http\Controllers;

use App\Http\Resources\WishListResource;
use App\WishList;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
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

    public function createList(Request $request)
    {

        $this->validate($request,[
            'product_id'    => 'required',
        ]);

        if ($request->isJson()) {

            $user = Auth::user();

            $wishList = WishList::where('buyer_id','=',$user->id)
                ->where('product_id','=',$request['product_id'])
                ->first();

            if (!$wishList){
                $data = $request->json()->all();
                $wishList = new WishList();
                $wishList->product_id    = $data['product_id'];
                $wishList->buyer_id      = $user->id;

                $wishList->save();
                return response()->json(new WishListResource($wishList), 201);
            } else {
                return response()->json(['error' => 'Duplicate row'], 406);
            }



        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function deleteList($id)
    {
        try {
            $user = Auth::user();
            $wish_list = WishList::where('id','=',$id)
                ->where('buyer_id','=',$user->id)->first();

            if($wish_list) {

                $wish_list->delete();
                return response()->json(new WishListResource($wish_list), 200);

            } else {
                return response()->json(['error' => 'Not found'], 401, []);
            }

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No content'], 406);
        }

    }

    public function getAllWishList()
    {
            $user = Auth::user();

            $wishList = WishList::where("buyer_id","=",$user->id)
                ->get();

            if($wishList){
                return WishListResource::collection($wishList);
            } else {
                return response()->json(['error' => 'Not found'], 406, []);
            }
    }

    public function getWishList($id)
    {
        $user = Auth::user();

        $wishList = WishList::where("buyer_id","=",$user->id)
            ->where('id','=',$id)
            ->first();

        if($wishList){
            return new WishListResource($wishList);
        } else {
            return response()->json(['error' => 'Not found'], 406, []);
        }
    }

}
