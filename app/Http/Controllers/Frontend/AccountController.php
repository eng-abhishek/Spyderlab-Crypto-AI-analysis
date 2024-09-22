<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CryptoPlanSubscription;
use App\Models\User;
use App\Models\Plan;
use App\Models\CryptoPlan;
use App\Models\CryptoPlanTransaction;
use Carbon\Carbon;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use DB;

class AccountController extends Controller
{
	public function __construct() {
		$this->middleware(['auth','verified']);
	}

    /**
     * View account.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$record = User::with('subscription')->find(auth()->user()->id);
    	
    	if(isset($record->subscription->plan_id)){
    		$plan_detail = CryptoPlan::where('id',$record->subscription->plan_id)->first();
    		
    		if(isset($plan_detail)){
    			if($plan_detail['is_free'] == 'Y'){
    				$record['plan_name'] = $plan_detail['name']." (Free Trail)";
    			}else{
    				$record['plan_name'] = $plan_detail['name']." (Premium Plan)";
    			}
    			$record['plan_slug'] = $plan_detail['slug'];
    		}else{
    			$record['plan_name'] = '';
    		}
    		$record['sub_exp_date'] = $record->subscription->expired_date; 
    	}

    	$top_plan = CryptoPlan::orderBy('yearly_price', 'desc')->first();

    	return view('frontend.account.setting', ['record' => $record, 'top_plan' => $top_plan]);
    }

    /**
     * view profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewProfile()
    {
    	$record = User::find(auth()->user()->id);
    	return view('frontend.account.setting', ['record' => $record]);
    }

    /**
     * Update profile.
     *
     * @param  \Illuminate\Http\UpdateProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
    	try {
    		$user = \Auth::user();
    		
    		$data = [
    			'name' => $request->get('name'),
    			'username' => $request->get('username'),
    		];

           //  if($user->isWeb3User() && $request->has('password') && $user->isGmailUser()){
           //     $data['password'] = Hash::make($request->get('password'));
           // }

    		if($request->has('password')){
    			$data['password'] = Hash::make($request->get('password'));
    		}
           // dd($data);
    		$user->update($data);

    		return redirect()->route('account.profile.view')->with(['status' => 'success', 'message' => 'Profile updated successfully.']);

    	} catch (\Exception $e) {
    		return redirect()->route('account.profile.view')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }

    /**
     * View change password.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function viewChangePassword()
    // {
    // 	return view('frontend.account.change-password');
    // }

    /**
     * Save change password.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function saveChangePassword(ChangePasswordRequest $request)
    {
    	try{
    		$user = \Auth::user();

    		User::where('id', $user->id)->update(['password'=> Hash::make($request->get('password'))]);

    		\Auth::logoutOtherDevices($request->get('password'));
    		
    		return redirect()->route('account.profile.view')->with(['status' => 'success', 'message' => 'Password has changed successfully.']);

    	} catch (\Exception $e) {
    		return redirect()->route('account.profile.view')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }

    public function viewSubscription(){
    	
    	$uid = \Auth::user()->id;

    	$plan_info = CryptoPlanSubscription::where(['user_id'=>$uid])->orderBy('id','desc')->get();
    	
    	$data['record'] = CryptoPlanSubscription::with('users','transations','plans')->where(['user_id'=>$uid])->orderBy('id','desc')->get();

    	if(count($plan_info)>0){
    		$plan_id = $plan_info[0]->plan_id; 

    		$next_record = CryptoPlan::where('id', '>', $plan_id)->orderBy('id')->first();

    		$previous_record = CryptoPlan::where('id', '<', $plan_id)->orderBy('id','desc')->first();

    		$upgradId =  (!is_null($next_record) ? $next_record->id : '');
    		$downgradid = (!is_null($previous_record) ? $previous_record->id : '');

    		$data['free_plan'] = CryptoPlan::where(['is_free'=>'Y','is_active'=>'Y'])->find($plan_id);
    		$data['chkUpgrad'] = CryptoPlan::where('is_active','Y')->find($upgradId);
    		$data['chkDowngrad'] = CryptoPlan::where('is_active','Y')->find($downgradid);
    	}

    	return view('frontend.account.subscription',$data);
    }

    public function buySubscription($slug){
    	DB::beginTransaction();
    	try{

    		$planinfo = CryptoPlan::where('slug',$slug)->first();
    		if(!is_null($planinfo)){
    			if($planinfo->is_free == 'Y'){
    				
    				$check_free_user = CryptoPlanSubscription::where('user_id',auth()->user()->id)->count();

                /* $check_free_user = CryptoPlanSubscription::whereHas('plans',function($q) use($planinfo){
                 $q->where('id',$planinfo->id);
                 $q->where('is_free','Y');
                 })->where('user_id',auth()->user()->id)->count();
                */
                 if($check_free_user > 0){
                 	return redirect()->route('blockchain-analysis')->with(['status' => 'danger', 'message' => 'Oop`s you have already taken subscription.']);
                 }

                 if(!is_null($planinfo->duration)){

                 	$exp_day = $planinfo->duration;

                 }else{
                 	$exp_day = 10;
                 }

                 $expired_plan = Carbon::now()->addDay($exp_day);
                 $plan_price = 0;

             }else{

             	if($request->get('plan_type')=='Y'){

             		$expired_plan = Carbon::now()->addYear();
             		$plan_price = $planinfo->yearly_price;

             	}else{

             		$expired_plan = Carbon::now()->addMonth();
             		$plan_price = $planinfo->monthly_price;

             	}
             }

             $create_subscription = CryptoPlanSubscription::Create([

             	'user_id' => auth()->user()->id,
             	'plan_id' => $planinfo->id,
             	'purchese_price' => $plan_price,
            // 'plan_type' => $request->get('plan_type'),
             	'created_by' => auth()->user()->id,
             	'updated_by' => auth()->user()->id,
             	'started_date' => Carbon::now(),
             	'expired_date' => $expired_plan,
             ]);
             DB::commit();
             CryptoPlanTransaction::Create([
             	'plan_id' => $planinfo->id,
              //'plan_type' => $request->get('plan_type'),
             	'sub_id' => $create_subscription->id,
             	'user_id' => auth()->user()->id,
             	'started_date' => Carbon::now(),
             	'expired_date' => $expired_plan,
             	'purchese_price' => $plan_price,
             	'created_by' => auth()->user()->id,
             ]);
             
             return redirect()->route('blockchain-analysis')->with(['status' => 'success', 'message' => 'Your subscription has activated successfully..']);
         }
     }catch(\Exception $e){
     	DB::rollback();
     	return redirect()->route('blockchain-analysis')->with(['status' => 'danger', 'message' => 'Oop`s something went wrong..']);
     }
 }

}
