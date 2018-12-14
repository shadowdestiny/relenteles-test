<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
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
        die("asdf");
        if ($request->isJson()) {

            $this->validate($request,[
                'stripeToken'       => 'required',
                'product_id'        => 'required',
                //'stripeTokenType'   => 'required',
                //'stripeEmail'       => 'required',
            ]);

            $user = Auth::user();

            $plan = 'plan_E1QZWsdIFxnKUa';
            //$stripeToken = $request->input('stripeToken');
            $stripeToken = $request->input('stripeToken');

            try {

                //$user->newSubscription('main',$plan)->create($stripeToken);
                $charge = Charge::create([
                    "amount"         => 102,
                    "currency"       => "usd",
                    "description"    => "prueba",
                    "source"         => $stripeToken,
                ]);

                die("hola");

                $sellerSale = new SellerSale();
                $sellerSale->product_id     = $request['product_id'];
                $sellerSale->user_id        = $user->id;
                $sellerSale->number_order   = '1234';

                return response()->json($charge, 200);
            } catch (\Exception $e){
                return response()->json(['error' => $e], 401);
            }


        }
    }


}
