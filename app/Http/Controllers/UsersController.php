<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tymon\JWTAuth\Facades\JWTAuth;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
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
            return User::all();
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function getSellers(Request $request)
    {
        if ($request->isJson()) {
            return User::where('type_user','=',User::SELLER)->get();
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function getBuyers(Request $request)
    {
        if ($request->isJson()) {
            return User::where('type_user','=',User::BUYER)->get();
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function createUser(Request $request)
    {
        if ($request->isJson()) {
            $data = $request->json()->all();
			
			$user = User::where("email","=",$data['email'])->first();
			
			if ($user){
				return response()->json(['error' => 'User found'], 401, []);
			} else {

                /*if ($data['password'] === $data['confirm_password']){*/

                    $user = User::create([
                        'first_name'                => $data['first_name'],
                        'last_name'                 => $data['last_name'],
                        'shipping_address'          => $data['shipping_address'],
                        'shipping_city'             => $data['shipping_city'],
                        'shipping_state'            => $data['shipping_state'],
                        'shipping_zipcode'          => $data['shipping_zipcode'],
                        'email'                     => $data['email'],
                        'password'                  => Hash::make($data['password']),
                        'api_token'                 => 'none',
                        'type_user' =>              $data['type_user'],
                    ]);

                    $user->api_token = JWTAuth::fromUser($user,['email'=>$user->email]);
                    $user->save();

                    return response()->json($user, 201);
                /*} else {

                    return response()->json(['error' => 'Password no merge'], 401, []);

                }*/
			}
        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function updateUser(Request $request, $id)
    {
        if ($request->isJson()) {

            try {
                $user = User::findOrFail($id);

                $data = $request->json()->all();

                //if ($data['password'] === $data['confirm_password']){
                    $user->first_name           = $data['first_name'];
                    $user->last_name            = $data['last_name'];
                    $user->shipping_address     = $data['shipping_address'];
                    $user->shipping_city        = $data['shipping_city'];
                    $user->shipping_state       = $data['shipping_state'];
                    $user->shipping_zipcode     = $data['shipping_zipcode'];
                    $user->last_name            = $data['last_name'];
                    $user->email                = $data['email'];
                    $user->password             = Hash::make($data['password']);
                    $user->api_token            = JWTAuth::refresh($user->api_token);
                    $user->save();

                    return response()->json(new UserResource($user), 200);
                /*} else {
                    return response()->json(['error' => 'Password no merge'], 401, []);
                }*/

            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function getUser(Request $request, $id)
    {
        if ($request->isJson()) {

            try {
                $user = User::find($id);
                return response()->json($user, 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }

    }

    public function deleteUser(Request $request, $id)
    {
        if ($request->isJson()) {

            try {
                $user = User::findOrFail($id);
                $user->delete();

                return response()->json($user, 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function getToken(Request $request)
    {
        if ($request->isJson()) {

            try {
                $data = $request->json()->all();
                $user = User::where('email', $data['email'])->first();

                if ($user){
                    $user->api_token = JWTAuth::fromUser($user,['email'=>$user->email]);
                    $user->save();

                    if ($user && Hash::check($data['password'], $user->password)) {
                        return response()->json(new UserResource($user), 200);
                    } else {
                        return response()->json(['error' => 'No content'], 406);
                    }
                } else {
                    return response()->json(['error' => 'User not found'], 406);
                }
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }
}
