<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\SellerSale;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentsController extends Controller
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

    public function createSubscription(Request $request)
    {
        if ($request->isJson()) {

            $this->validate($request,[
                'stripeToken'       => 'required',
                'product_id'        => 'required',
            ]);

            $user = Auth::user();

            Stripe::setApiKey(env('STRIPE_KEY'));
            $stripeToken = $request->input('stripeToken');

            $product = Product::find($request->input("product_id"));

            if ($product){
                DB::beginTransaction();

                $charge = Charge::create([
                    "amount"         => $product->price,
                    "currency"       => "usd",
                    "description"    => "product",
                    "source"         => $stripeToken["id"],
                ]);

                $sellerSale = new SellerSale();
                $sellerSale->product_id     = $request['product_id'];
                $sellerSale->user_id        = $user->id;
                $sellerSale->number_order   = $charge->created;
                $sellerSale->seller_id      = $product->seller->id;

                $sellerSale->save();

                DB::commit();

                return response()->json($charge, 200);
            } else {
                return response()->json(['error' => 'Not found product'], 401);
            }

        }
    }


}
