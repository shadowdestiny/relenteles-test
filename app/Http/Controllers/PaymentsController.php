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

    public function createPayment(Request $request)
    {
        if ($request->isJson()) {

            $this->validate($request,[
                'stripeToken'       => 'required',
                'product_id'        => 'required',
                //'code'              => 'required', //temporal, esto hay que quitarlo
            ]);


            $user = Auth::user();

            Stripe::setApiKey(env('STRIPE_KEY'));
            $stripeToken = $request->input('stripeToken');

            if (is_array($request["product_id"])){

                // Create a Customer:
                $customer = \Stripe\Customer::create([
                    'source'    => $stripeToken,
                    'email'     => $user->email,
                ]);

                foreach ($request["product_id"] as $product_id){

                    $product = Product::find($product_id);

                    if ($product->seller->stripe_id === null)
                        return response()->json(['error' => 'Not found stripe_id in user'], 401);

                    if ($product){
                        DB::beginTransaction();

                        $amount = $product->price;
                        $fee = ($amount * 10) / 100;

                        $charge = Charge::create([
                            "amount"         => ($amount - $fee) * 100,
                            "currency"       => "usd",
                            "description"    => "product",
                            'customer'       => $customer->id,
                            "application_fee" => ceil($fee * 100),
                        ],["stripe_account" => $product->seller->stripe_id]);

                        $sellerSale = new SellerSale();
                        $sellerSale->product_id     = $product_id;
                        $sellerSale->user_id        = $user->id;
                        $sellerSale->number_order   = $charge->created;
                        $sellerSale->seller_id      = $product->seller->id;

                        $sellerSale->save();

                        DB::commit();


                    } else {
                        return response()->json(['error' => 'Not found product'], 401);
                    }

                    return response()->json("Ok", 200);
                }
            } else {
                $product = Product::find($request->input("product_id"));

                if ($product->seller->stripe_id === null)
                    return response()->json(['error' => 'Not found stripe_id in user'], 401);

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
                    ],["stripe_account" => $product->seller->stripe_id]);

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


}
