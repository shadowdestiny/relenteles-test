<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tymon\JWTAuth\Facades\JWTAuth;
//use Intervention\Image\Facades\Image;

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

    public function getAll()
    {
         return User::all();
    }

    public function getSellers()
    {
            return User::where('type_user','=',User::SELLER)->get();
    }

    public function getBuyers(Request $request)
    {

            return User::where('type_user','=',User::BUYER)->get();

    }

    public function createUser(Request $request)
    {
        if ($request->isJson()) {

            $this->validate($request,[
                'first_name'            => 'required|max:255',
                'last_name'             => 'required|max:255',
                'shipping_address'      => 'required|max:255',
                'shipping_city'         => 'required|max:255',
                'shipping_state'        => 'required|integer',
                'shipping_zipcode'      => 'required|max:50',
                'youtube_url'           => 'max:512',
                'spotify_url'           => 'max:512',
                'podcast_url'           => 'max:512',
                'itunes_url'           => 'max:512',
                'email'                 => 'required|max:100|unique:users',
                'type_user'             => 'required|integer',
                'image'                 => 'max:1024',
            ]);

            $data = $request->json()->all();
			
			$user = User::where("email","=",$data['email'])->first();
			
			if ($user){
				return response()->json(['error' => 'User already exists'], 401, []);
			} else {

                /*if ($data['password'] === $data['confirm_password']){*/

                    $user = User::create([
                        'first_name'                => $data['first_name'],
                        'last_name'                 => $data['last_name'],
                        'shipping_address'          => $data['shipping_address'],
                        'shipping_city'             => $data['shipping_city'],
                        'shipping_state'            => $data['shipping_state'],
                        'shipping_zipcode'          => $data['shipping_zipcode'],
                        'youtube_url'               => $data['youtube_url'],
                        'spotify_url'               => $data['spotify_url'],
                        'podcast_url'               => $data['podcast_url'],
                        'itunes_url'                => $data['itunes_url'],
                        'email'                     => $data['email'],
                        'password'                  => Hash::make($data['password']),
                        'api_token'                 => 'none',
                        'image'                     => $data['image'],
                        'type_user'                 => $data['type_user'],
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

            $this->validate($request,[
                'first_name'            => 'required|max:255',
                'last_name'             => 'required|max:255',
                'shipping_address'      => 'required|max:255',
                'shipping_city'         => 'required|max:255',
                'shipping_state'        => 'required|integer',
                'shipping_zipcode'      => 'required|max:50',
                'email'                 => 'required|max:100',
                'youtube_url'           => 'max:512',
                'spotify_url'           => 'max:512',
                'podcast_url'           => 'max:512',
                'itunes_url'            => 'max:512',
                'image'                 => 'max:1024',
            ]);

            try {
                $user = User::findOrFail($id);

                $data = $request->json()->all();

                if (User::where('id','<>',$id)->where('email','=',$data['email'])->first()) {
                    return response()->json(['error' => 'Other user is assigned this email'], 406);
                } else {

                    //if ($data['password'] === $data['confirm_password']){
                        $user->first_name           = $data['first_name'];
                        $user->last_name            = $data['last_name'];
                        $user->shipping_address     = $data['shipping_address'];
                        $user->shipping_city        = $data['shipping_city'];
                        $user->shipping_state       = $data['shipping_state'];
                        $user->shipping_zipcode     = $data['shipping_zipcode'];
                        $user->last_name            = $data['last_name'];
                        $user->youtube_url          = $data['youtube_url'];
                        $user->spotify_url          = $data['spotify_url'];
                        $user->podcast_url          = $data['podcast_url'];
                        $user->itunes_url           = $data['itunes_url'];
                        $user->email                = $data['email'];
                        $user->image                = $data['image'];
                        $user->password             = Hash::make($data['password']);
                        $user->api_token            = JWTAuth::fromUser($user,['email'=>$user->email]);
                        $user->save();

                        return response()->json(new UserResource($user), 200);
                    /*} else {
                        return response()->json(['error' => 'Password no merge'], 401, []);
                    }*/
                }

            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function getUser(Request $request, $id)
    {

            try {
                $user = User::find($id);
                return response()->json($user, 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No content'], 406);
            }

    }

    public function deleteUser( $id)
    {

        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No content'], 406);
        }

    }

    public function logout(Request $request){
        $token=JWTAuth::getToken();
        JWTAuth::invalidate($token);
        return response()->json(['logout' => 'Ok'], 200, []);
    }

    public function getToken(Request $request)
    {
        if ($request->isJson()) {

            try {
                config()->set('jwt.ttl', 60*60*7);
                $data = $request->json()->all();
                $user = User::where('email', $data['email'])->first();

                if ($user){

                    $user->api_token = JWTAuth::fromUser($user,['email'=>$user->email,'exp' => Carbon::now()->addDays(7)->timestamp]);
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
