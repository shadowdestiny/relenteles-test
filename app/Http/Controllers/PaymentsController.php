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
use Stripe\OAuth;
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

    public function authStripe(Request $request){
        if ($request->isJson()) {

            $this->validate($request, [
                'code' => 'required', //temporal, esto hay que quitarlo
            ]);

            try {

                $token_request_body = array(
                    'client_secret' => env('STRIPE_KEY'),
                    'grant_type' => 'authorization_code',
                    //'client_id' => CLIENT_ID,
                    'code' => $request["code"],
                );

                Stripe::setApiKey(env('STRIPE_KEY'));
                $result = OAuth::token($token_request_body);

                return response()->json($result, 200);

            } catch (\Exception $e) {
                return response()->json(['error' => $e], 401);
            }
        }
    }

    public function createSubscription(Request $request)
    {
        if ($request->isJson()) {

            $this->validate($request,[
                'stripeToken'       => 'required',
                'product_id'        => 'required',
                'code'              => 'required', //temporal, esto hay que quitarlo
            ]);

            $user = Auth::user();

            Stripe::setApiKey(env('STRIPE_KEY'));
            $stripeToken = $request->input('stripeToken');

            $product = Product::find($request->input("product_id"));

            if ($product){
                DB::beginTransaction();

                $amount = $product->price;
                $fee = ($amount * 10) / 100;

                $charge = Charge::create([
                    "amount"         => ($amount - $fee) * 100,
                    "currency"       => "usd",
                    "description"    => "product",
                    "source"         => $stripeToken,
                    "application_fee" => ceil($fee * 100),
                ],["stripe_account" => $request["code"]]);

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
