<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\UserKey;
use App\Models\BlockchainAddressDetail;
use App\Models\CryptoPlanSubscription;

class AuthKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
 
        $headers = $request->header('x-api-key');

        $user_keys = UserKey::with('users')->where(['key'=>$headers])->first();
        
        if(is_null($user_keys) || is_null($user_keys->users)){

        return response()->json(['message' => 'Oop`s unauthorized key','data' => '','status' => false,'code'=> 401]);
        }

        $user_keys_status = UserKey::with('users')->where(['key'=>$headers,'is_active'=>'Y'])->first();

        if(is_null($user_keys_status) || is_null($user_keys_status->users)){

        return response()->json(['message' => 'Oop`s currently your key do not active','data' => '','status' => false,'code'=> 401]);
        }


        $chk_user_sub = CryptoPlanSubscription::whereHas('plans',function($query){

         $query->where('is_free','N');

        })->where('user_id', $user_keys->users->id)->first();
        
        if(is_null($chk_user_sub)){

            return response()->json(['message' => 'Oop`s you have not any paid plan','data' => '','status' => false,'code'=> 404]);
        }


        $check_active_sub = CryptoPlanSubscription::where('user_id', $user_keys->users->id)->where('is_active','Y')->first();

        if(is_null($check_active_sub)){

             return response()->json(['message' => 'Oop`s currently your subscription has deactivated by admin' ,'data' => '','status' => false,'code'=> 404]);
        }

        
         $expiry_subs = CryptoPlanSubscription::where('user_id', $user_keys->users->id)->where('expired_date', '>', now())->where('is_active','Y')->first();

        if(is_null($expiry_subs)){

            return response()->json(['message' => 'Oop`s currently your subscription has expired','data' => '','status' => false, 'code'=> 404]);
        }
       
       return $next($request);

    }
}
