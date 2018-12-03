<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\ProductResource;

use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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

            return response()->json(ProductResource::collection(Product::all()), 200);

    }

    public function getMeProducts()
    {
            $user = Auth::user();

            $product = Product::where('seller_id','=',$user->id)->get();

            if ($product)
                return response()->json(ProductResource::collection($product), 200);
            else {
                return response()->json(['error' => 'Not found'], 401, []);
            }

    }

    public function getProductsByCategory($category_id)
    {

        $product = Product::where('category_id','=',$category_id)
            ->get();

        return response()->json(ProductResource::collection($product), 200);

    }

    public function getProductsBySeller($seller_id)
    {

        $product = Product::where('seller_id','=',$seller_id)
            ->get();

        return response()->json(ProductResource::collection($product), 200);

    }

    public function getProductsFind(Request $request)
    {
        if ($request->isJson()) {

            $product = Product::where('name','like','%'.$request->input('string_find').'%');



            if (strlen($request["category_id"]) > 0)
                $product->where('category_id','=',$request->input('string_find'));

            if (strlen($request["by_price"]) > 0) {
                if ($request["by_price"] === "price_high_low")
                    $product->orderBy("price", "asc");
                else if ($request["by_price"] === "price_low_high")
                    $product->orderBy("price", "desc");
            }

            if (strlen($request["by_rating"]) > 0){
                if($request["rating_high_low"])
                    $product->where('1','=','1');
                else if($request["rating_low_high"])
                    $product->where('1','=','1');
            }

            $product = $product->get();

            return response()->json(ProductResource::collection($product), 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function createProduct(Request $request)
    {

        $this->validate($request,[
            'name'          => 'required|max:100',
            'description'   => 'required|max:255',
            'price'         => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'category_id'   => 'required|integer',
        ]);

        if ($request->isJson()) {

            $user = Auth::user();

            $data = $request->json()->all();
            $product = new Product();
            $product->name          = $data['name'];
            $product->description   = $data['description'];
            $product->price         = $data['price'];
            $product->seller_id     = $user->id;
            $product->category_id   = $data['category_id'];

            $product->save();

            return response()->json($product, 201);

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        if ($request->isJson()) {

            $this->validate($request,[
                'name'          => 'required|max:100',
                'description'   => 'required|max:255',
                'price'         => 'required|regex:/^\d*(\.\d{1,2})?$/',
                'category_id'   => 'required|integer',
            ]);

            try {

                $user = Auth::user();

                $product = Product::where('id','=',$id)
                    ->where('seller_id','=',$user->id)->first();

                if ($product){
                    $data = $request->json()->all();

                    $product->name          = $data['name'];
                    $product->description   = $data['description'];
                    $product->price         = $data['price'];
                    $product->seller_id     = $user->id;
                    $product->category_id   = $data['category_id'];

                    $product->save();

                    return response()->json($product, 200);

                } else {
                    return response()->json(['error' => 'Not found'], 401, []);
                }

            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function getProduct($id)
    {


            try {
                $product = Product::find($id);
                if ($product)
                    return response()->json(new ProductResource($product), 200);
                else
                    return response()->json(['error' => 'Not found'], 406);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }



    }

    public function deleteProduct($id)
    {

            try {
                $user = Auth::user();
                $product = Product::where('id','=',$id)
                    ->where('seller_id','=',$user->id)->first();

                if($product) {
                    $product->delete();
                    return response()->json($product, 200);
                } else {
                    return response()->json(['error' => 'Not found'], 401, []);
                }

            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }

    }

}
