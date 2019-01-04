<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingBuyerResource;
use App\Http\Resources\SettingSellerResource;
use App\Setting;
use App\SettingForBuyer;
use App\SettingForSeller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
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

    public function getAllSettingSeller()
    {

            $setting = Setting::where('type',Setting::TYPE_NOTIFICATION_SELLER)->get();

            if($setting){
                return SettingSellerResource::collection($setting);
            } else {
                return response()->json(['error' => 'Not found'], 406, []);
            }

    }

    public function getOneSettingSeller($id)
    {

        $setting = Setting::where('type',Setting::TYPE_NOTIFICATION_SELLER)
            ->where('id',$id)
            ->first();

        if($setting){
            return new SettingSellerResource($setting);
        } else {
            return response()->json(['error' => 'Not found'], 406, []);
        }

    }

    public function getOneSettingBuyer($id)
    {

        $setting = Setting::where('type',Setting::TYPE_NOTIFICATION_BUYER)
            ->where('id',$id)
            ->first();

        if($setting){
            return new SettingBuyerResource($setting);
        } else {
            return response()->json(['error' => 'Not found'], 406, []);
        }

    }

    public function getAllSettingBuyer()
    {

        $setting = Setting::where('type',Setting::TYPE_NOTIFICATION_BUYER)->get();

        if($setting){
            return SettingBuyerResource::collection($setting);
        } else {
            return response()->json(['error' => 'Not found'], 406, []);
        }

    }

    public function checkSettingSeller(Request $request)
    {

        $this->validate($request,[
            'code' => 'required|max:100',
            'checked' => 'required|boolean',
        ]);

        $user = Auth::user();

        $settingForSeller = SettingForSeller::join('settings','settings.id','=','setting_for_sellers.setting_id')
            ->where("seller_id","=",$user->id)
            ->where('settings.type','=',Setting::TYPE_NOTIFICATION_SELLER)
            ->where('settings.code','=',$request['code'])
            ->select("setting_for_sellers.id")
            ->first();

        if ($request["checked"] === true){

            if(!$settingForSeller){

                $setting = Setting::where('code',$request["code"])->first();

                $newSettingForSeller = new SettingForSeller();
                $newSettingForSeller->setting_id    = $setting->id;
                $newSettingForSeller->seller_id     = $user->id;
                $newSettingForSeller->save();
            }

            $setting = Setting::where('type',Setting::TYPE_NOTIFICATION_SELLER)->get();
            return SettingSellerResource::collection($setting);
        } else {
            if ($settingForSeller)
                $settingForSeller->delete();

            $setting = Setting::where('type',Setting::TYPE_NOTIFICATION_SELLER)->get();
            return SettingSellerResource::collection($setting);
        }

    }

    public function checkSettingBuyer(Request $request)
    {

        $this->validate($request,[
            'code' => 'required|max:100',
            'checked' => 'required|boolean',
        ]);

        $user = Auth::user();

        $settingForBuyer = SettingForBuyer::join('settings','settings.id','=','setting_for_buyers.setting_id')
            ->where("buyer_id","=",$user->id)
            ->where('settings.type','=',Setting::TYPE_NOTIFICATION_BUYER)
            ->where('settings.code','=',$request['code'])
            ->select("setting_for_buyers.id")
            ->first();

        if ($request["checked"] === true){

            if(!$settingForBuyer){

                $setting = Setting::where('code',$request["code"])->first();

                $newSettingForBuyer = new SettingForBuyer();
                $newSettingForBuyer->setting_id    = $setting->id;
                $newSettingForBuyer->buyer_id      = $user->id;
                $newSettingForBuyer->save();
            }

            $setting = Setting::where('type',Setting::TYPE_NOTIFICATION_BUYER)->get();
            return SettingBuyerResource::collection($setting);
        } else {
            if ($settingForBuyer)
                $settingForBuyer->delete();

            $setting = Setting::where('type',Setting::TYPE_NOTIFICATION_BUYER)->get();
            return SettingBuyerResource::collection($setting);
        }

    }
}
