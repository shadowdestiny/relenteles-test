<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Auth;
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
                //'stripeTokenType'   => 'required',
                //'stripeEmail'       => 'required',
            ]);

            $user = Auth::user();

            $plan = 'plan_E1QZWsdIFxnKUa';
            $stripeToken = $request->input('stripeToken');

            try {
                $user->newSubscription('main',$plan)->create($stripeToken);
                return response()->json(['successful' => 'Ok'], 200);
            } catch (\Exception $e){
                return response()->json(['error' => $e], 401);
            }

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }


}
