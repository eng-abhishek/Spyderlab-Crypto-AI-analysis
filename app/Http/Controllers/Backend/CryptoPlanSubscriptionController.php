<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\SubscriptionRequest;
use App\Models\CryptoPlanSubscription;
use App\Models\User;
use App\Models\Plan;
use App\Models\CryptoPlan;
use App\Models\CryptoPlanTransaction;
use DataTables;
use Carbon\Carbon;
use Auth;
use DB;

class CryptoPlanSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax()) {
            $data = CryptoPlanSubscription::with('users','transations','plans');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('username', function($row){
                return $row->users->username;
            })
            ->addColumn('plan', function($row){
               return $row->plans->name;
           })
            
            ->addColumn('plan_price', function($row){
                return '$ '.$row->plans->monthly_price;
            })

            ->addColumn('started_date', function($row){
               return Carbon::parse($row->started_date)->format('Y-m-d H:i:s');
           })

            ->addColumn('expired_date', function($row){
                return Carbon::parse($row->expired_date)->format('Y-m-d H:i:s');
            })

            ->addColumn('is_active',function($row){
                if($row->is_active == 'Y'){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $is_active='<div class="form-check form-switch">
                <input type="checkbox" '.$checked.' class="is_active'.$row->id.' form-check-input" id="customSwitch1" data-id="'.$row->id.'">
                <label class="form-check-label" for="customSwitch1"></label>
                </div>';
                return $is_active;
            })

            ->addColumn('plan_status',function($row){
             $plan_status= '';
             if(plan_is_expire_backend($row->id) == 'Y'){

                 $plan_status.='<span class="badge bg-danger rounded-pill">Expired</span>';

             }else{

                 $plan_status.='<span class="badge bg-primary rounded-pill">Active</span>';

             }
             return $plan_status;
         })

            ->addColumn('action', function($row){

               $next_record = CryptoPlan::where('id', '>', $row->plan_id)->orderBy('id')->first();

               $previous_record = CryptoPlan::where('id', '<', $row->plan_id)->orderBy('id','desc')->first();

               $upgradId =  (!is_null($next_record) ? $next_record->id : '');
               $downgradid = (!is_null($previous_record) ? $previous_record->id : '');

               $free_plan = CryptoPlan::where(['is_active'=>'Y','is_free'=>'Y'])->find($row->plan_id);

               $chkUpgrad = CryptoPlan::where('is_active','Y')->where('is_free','!=','Y')->find($upgradId);

               $chkDowngrad = CryptoPlan::where('is_active','Y')->where('is_free','!=','Y')->find($downgradid);

               $btn = '';
               $btn.='<div class="dropstart">
               <a class="btn btn-outline-light btn-sm dropdown-toggle no-caret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               <i class="fa-solid fa-ellipsis"></i>
               </a>
               <ul class="dropdown-menu">';
               if(!is_null($free_plan)){

                   $btn.='<li><a class="dropdown-item" href="'.route("backend.subscription.upgrade", $row->id).'">Upgrade</a></li>';

               }else{

                   if(!is_null($chkUpgrad)){

                    $btn.='<li><a class="dropdown-item" href="'.route("backend.subscription.upgrade", $row->id).'">Upgrade</a></li>';
                }

                $btn.='<li><a href="'.route('backend.subscription.renew', $row->id).'" class="renew-record dropdown-item">Renew</a></li>';

                if(!is_null($chkDowngrad)){
                    $btn.='<li><a class="dropdown-item" href="'.route("backend.subscription.downgrade", $row->id).'">Downgrade</a></li>';
                }
            }

            $btn.='<li><a href="'.route('backend.subscription.edit', $row->id).'" class="dropdown-item">Edit</a></li>';

            $btn.='</ul>
            </div>';
            return $btn;
        })
            ->filter(function ($instance) use ($request) {
               if ($request->get('status') != '') {
                $instance->where('is_active', $request->get('status'));
            }
            
            if ($request->get('plan') != '') {

                //$instance->where('name', $request->get('plan'));

               $instance->where(function($w) use($request){
                $plan = $request->get('plan');

                $w->whereHas('plans', function($user) use($plan){
                    $user->where('name',$plan);
                });
            });
           }

           if ($request->get('user') != '') {

                //$instance->where('name', $request->get('plan'));
               $instance->where(function($w) use($request){
                $find_user = $request->get('user');

                $w->whereHas('users', function($user) use($find_user){
                    $user->where('username',$find_user);
                });
            });
           }

           if (!empty($request->get('search'))) {
            $instance->where(function($w) use($request){
                $search = $request->get('search');

                $w->whereHas('plans', function($user) use($search){
                    $user->where('name', 'LIKE', "%$search%");
                });
                $w->orwhereHas('users', function($user) use($search){
                    $user->where('username', 'LIKE', "%$search%");
                });
            });
        }
    })
            ->rawColumns(['plan_status','username','plan','subscription','plan_price','started_date','is_active','expired_date','action'])
            ->make(true);
        }
        
        $data['plan_list']= CryptoPlan::all();
        $data['user_list']= User::where('is_admin','N')->get();
        return view('backend.subscription.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $a = CryptoPlanSubscription::where('user_id',105)->first();
        // dd($a);
        $data['user'] = User::whereDoesntHave('subscription')->where(['is_active'=>'Y','is_admin'=>'N'])->get();
        
        $data['plan'] = CryptoPlan::where('is_active','Y')->pluck('name','id');
        return view('backend.subscription.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionRequest $request)
    {
        DB::beginTransaction();
        try{

            $planData = CryptoPlan::find($request->get('plan_id'));

            if(isset($planData->id)){
                $planInfo = CryptoPlan::find($planData->id);
            }

            if($planInfo->is_free == 'Y'){

               $plan_type = null;

               if(!is_null($planInfo->duration)){

                  $exp_day = $planInfo->duration;

              }else{
                 $exp_day = 10;
             }

             $expired_plan = Carbon::now()->addDay($exp_day);
             $plan_price = 0;

         }else{

            if($request->get('terms_in_month')){

               $terms_in_month = $request->get('terms_in_month');

               $expired_plan = Carbon::now()->addMonths($request->get('terms_in_month'));
               $plan_price = round($planInfo->monthly_price * $terms_in_month,2);

           }
       }


       $create_subscription = CryptoPlanSubscription::Create([

        'user_id' => $request->get('user_id'),
        'plan_id' => $request->get('plan_id'),
        'purchese_price' => $plan_price,
        'plan_type' => 'M',
        'created_by' => Auth::guard('backend')->user()->id,
        'updated_by' => Auth::guard('backend')->user()->id,
        'terms_in_month' => $request->get('terms_in_month'),
        'started_date' => Carbon::now(),
        'expired_date' => $expired_plan,
    ]);

       CryptoPlanTransaction::Create([
         'plan_id' => $request->get('plan_id'),
         'plan_type' => 'M',
         'sub_id' => $create_subscription->id,
         'user_id' => $request->get('user_id'),
         'started_date' => Carbon::now(),
         'terms_in_month' => $request->get('terms_in_month'),
         'expired_date' => $expired_plan,
         'purchese_price' => $plan_price,
         'created_by' => Auth::guard('backend')->user()->id,
     ]);
       DB::commit();
       return redirect()->route('backend.subscription.index')->with(['status'=>'success','message'=>'Your subscription has saved successfully..']);

   }catch(\Exception $e){
       DB::rollback();
       return redirect()->route('backend.subscription.create')->with(['status'=>'danger','message'=>'Oop`s something went wrong..']);
   }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\CryptoPlanSubscription  $cryptoPlanSubscription
     * @return \Illuminate\Http\Response
     */
    public function show(CryptoPlanSubscription $cryptoPlanSubscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CryptoPlanSubscription  $cryptoPlanSubscription
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['record'] = CryptoPlanSubscription::find($id);
        $data['user'] = User::where(['id'=>$data['record']->user_id])->pluck('name');
        $data['plan'] = CryptoPlan::pluck('name','id');
        $data['is_free'] = CryptoPlan::find($data['record']->plan_id)->is_free;
        return view('backend.subscription.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CryptoPlanSubscription  $cryptoPlanSubscription
     * @return \Illuminate\Http\Response
     */
    public function update(SubscriptionRequest $request,$id)
    {
        DB::beginTransaction();
        try{

            $subId = CryptoPlanSubscription::find($id);

            if(!is_null($subId)){

                $planInfo = CryptoPlan::find($request->get('plan_id'));
                if(!is_null($planInfo)){
                    if($planInfo->is_active == 'N'){
                        return redirect()->route('backend.subscription.edit',$id)->with(['status'=>'danger','message'=>'Oop`s this plan has currently deactivated by admin.']);
                    }
                }

                $userInfo = User::find($subId->user_id);
                if(!is_null($userInfo)){
                    if($userInfo->is_active == 'N'){
                        return redirect()->route('backend.subscription.edit',$id)->with(['status'=>'danger','message'=>'Oop`s this user has currently deactivated by admin.']);
                    }
                }

                if($planInfo->is_free == 'Y'){

                   $plan_type = null;

                   if(!is_null($planInfo->duration)){

                      $exp_day = $planInfo->duration;

                  }else{
                     $exp_day = 10;

                 }

                 $expired_date = Carbon::now()->addDay($exp_day);
                 $plan_price = 0;

             }else{

            if($request->get('terms_in_month')){

               $terms_in_month = $request->get('terms_in_month');

               $expired_date = Carbon::now()->addMonths($request->get('terms_in_month'));
               $plan_price = round($planInfo->monthly_price * $terms_in_month,2);

           }
           }

           $subRenewData = [
            'updated_by' => Auth::guard('backend')->user()->id,
            'expired_date' => $expired_date,
            'purchese_price' => $plan_price,
            'plan_id' => $request->get('plan_id'),
            'plan_type' => $plan_type,
            'started_date' => Carbon::now(),
        ];

        CryptoPlanSubscription::where('id',$subId->id)->update($subRenewData);

        $delSubscription = CryptoPlanTransaction::take(1)->where('sub_id',$subId->id)->orderby('id','desc')->pluck('id');

        if(!is_null($delSubscription)){

            $update_tr = [
             'plan_id' =>  $request->get('plan_id'),
             'plan_type' => $plan_type,
             'created_by' => Auth::guard('backend')->user()->id,
             'purchese_price' => $plan_price,
             'started_date' => Carbon::now(),
             'expired_date' => $expired_date,
         ];

         CryptoPlanTransaction::where('id',$delSubscription[0])->update($update_tr);

     }else{
       DB::rollback();
       return redirect()->route('backend.subscription.edit',$id)->with(['status'=>'danger','message'=>'Oop`s subscription id is not getting..']);
   }
   
   DB::commit();
   return redirect()->route('backend.subscription.index')->with(['status'=>'success','message'=>'Your subscription has edit successfully..']);

}else{
    DB::rollback();
    return redirect()->route('backend.subscription.edit',$id)->with(['status'=>'danger','message'=>'Oop`s subscription id is not getting..']);

}
}catch(\Exception $e){
 DB::rollback();
 return redirect()->route('backend.subscription.edit',$id)->with(['status'=>'danger','message'=>'Oop`s something went wrong..']);
}
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CryptoPlanSubscription  $cryptoPlanSubscription
     * @return \Illuminate\Http\Response
     */

    public function upgrade($id){

        $subId = CryptoPlanSubscription::find($id);

        if(!is_null($subId)){
            $data['record'] = $subId;
            
            /*
             * check free plan 
            */
            $check_free_plan = CryptoPlan::where('id',$subId->plan_id)->first();
            if($check_free_plan->is_free == 'Y'){

                $data['plan'] = CryptoPlan::where(['is_free'=>'N'])->pluck('name','id');
            }else{

                $data['plan'] = CryptoPlan::where('id','>',$subId->plan_id)->where(['is_free'=>'N'])->orderby('id','asc')->pluck('name','id');

            }     
            $data['user'] = User::where(['id'=>$subId->user_id])->pluck('name');
        }
  
        return view('backend.subscription.upgrade',$data);
    }

    public function downgrade($id){

        $subId = CryptoPlanSubscription::find($id);
        if(!is_null($subId)){
            $data['record'] = $subId;
            $data['plan'] = CryptoPlan::where('id','<',$subId->plan_id)->where(['is_free'=>'N'])->pluck('name','id');
            $data['user'] = User::where(['id'=>$subId->user_id])->pluck('name');

        }
        return view('backend.subscription.downgrade',$data);
    }
    
    public function change_plan(Request $request,$id){
        DB::beginTransaction();
        try{

            $subId = CryptoPlanSubscription::find($id);

            if(!is_null($subId)){

                $planInfo = CryptoPlan::find($request->get('plan_id'));
                if(!is_null($planInfo)){
                    if($planInfo->is_active == 'N'){
                        return redirect()->route('backend.subscription.'.$request->segment(3),$id)->with(['status'=>'danger','message'=>'Oop`s this plan has currently deactivated by admin.']);
                    }
                }

                $userInfo = User::find($subId->user_id);
                if(!is_null($userInfo)){
                    if($userInfo->is_active == 'N'){
                        return redirect()->route('backend.subscription.'.$request->segment(3),$id)->with(['status'=>'danger','message'=>'Oop`s this user has currently deactivated by admin.']);
                    }
                }

    
            if($request->get('terms_in_month')){

               $terms_in_month = $request->get('terms_in_month');

               $expired_date = Carbon::now()->addMonths($request->get('terms_in_month'));
               $plan_price = round($planInfo->monthly_price * $terms_in_month,2);

           }


            if($request->segment(3) == 'upgrade'){
                $type = 'U';
            }else{
                $type = 'D';
            }

            $subRenewData = [
                'updated_by' => Auth::guard('backend')->user()->id,
                'expired_date' => $expired_date,
                'plan_id' => $request->get('plan_id'),
                'plan_type' => $request->get('plan_type'),
                'purchese_price' => $plan_price,
                'started_date' => Carbon::now(),
            ];

            CryptoPlanSubscription::where('id',$subId->id)->update($subRenewData);

            CryptoPlanTransaction::Create([
             'sub_id' => $subId->id,
             'user_id' => $subId->user_id,
             'plan_id' =>  $request->get('plan_id'),
             'plan_type' => $request->get('plan_type'),
             'created_by' => Auth::guard('backend')->user()->id,
             'purchese_price' => $plan_price,
             'started_date' => Carbon::now(),
             'expired_date' => $expired_date,
             'plan_change_type' => $type,
         ]);
            DB::commit();
            return redirect()->route('backend.subscription.index')->with(['status'=>'success','message'=>'Your subscription has '.$request->segment(3).' successfully..']);

        }else{
         DB::rollback();
         return redirect()->route('backend.subscription.'.$request->segment(3),$id)->with(['status'=>'danger','message'=>'Oop`s subscription id is not getting..']);

     }
 }catch(\Exception $e){
    DB::rollback();
    return redirect()->route('backend.subscription.'.$request->segment(3),$id)->with(['status'=>'danger','message'=>'Oop`s something went wrong..']);
}
}

public function renew(Request $request,$id){
 DB::beginTransaction();
 try{

    $subId = CryptoPlanSubscription::find($id);

    if(!is_null($subId)){

        $planInfo = CryptoPlan::find($subId->plan_id);

        if(is_null($planInfo)){

          return redirect()->route('backend.subscription.index')->with(['status'=>'danger','message'=>'Oop`s Your plan has deactivated by admin, you need to upgrade or downgrade your subscription..']);

       }
       if(!is_null($planInfo)){
        if($planInfo->is_active == 'N'){

          return redirect()->route('backend.subscription.index')->with(['status'=>'danger','message'=>'Oop`s this plan has currently deactivated by admin.']);
        }

        if($planInfo->is_free == 'Y'){

           return redirect()->route('backend.subscription.index')->with(['status'=>'danger','message'=>'Oop`s free plan has not renewed.']);

        }                
    }

    $userInfo = User::find($subId->user_id);
    if(!is_null($userInfo)){
        if($userInfo->is_active == 'N'){

     return redirect()->route('backend.subscription.index')->with(['status'=>'danger','message'=>'Oop`s this user has currently deactivated by admin.']);

        }
    }

        $terms_in_month = $subId->terms_in_month;

        $expired_date = Carbon::now()->addMonths($terms_in_month);
        $plan_price = round($planInfo->monthly_price * $terms_in_month,2);


    $subRenewData = [
        'updated_by' => Auth::guard('backend')->user()->id,
        'expired_date' => $expired_date,
        'started_date' => Carbon::now(),
        'purchese_price' => $plan_price,
        'plan_type' => 'M',
    ];

    CryptoPlanSubscription::where('id',$id)->update($subRenewData);

    CryptoPlanTransaction::Create([
     'sub_id' => $id,
     'user_id' => $subId->user_id,
     'plan_id' =>  $subId->plan_id,
     'plan_type' => $request->get('type'),
     'created_by' => Auth::guard('backend')->user()->id,
     'purchese_price' => $plan_price,
     'started_date' => Carbon::now(),
     'expired_date' => $expired_date,
     'plan_change_type' => 'R',
 ]);
    DB::commit();
    
     return redirect()->route('backend.subscription.index')->with(['status'=>'success','message'=>'Your subscription has renew successfully.']);


}else{
    DB::rollback();

return redirect()->route('backend.subscription.index')->with(['status'=>'danger','message'=>'Oop`s subscription id is not getting.']);


}
}catch(\Exception $e){
    DB::rollback();

return redirect()->route('backend.subscription.index')->with(['status'=>'danger','message'=>'Oop`s something went wrong.']);


}
}

public function changeStatus(Request $request){
    try{
     $cryptoData=CryptoPlanSubscription::find($request->id);
     $cryptoData->is_active=$request->is_active;
     $cryptoData->save();
     if($request->is_active=='Y'){

       return response()->json(['status'=>'success','message'=>'Subscription has activated successfully..']);    
   }elseif($request->is_active=='N'){

       return response()->json(['status'=>'success','message'=>'Subscription has Inactivated successfully.']);
   }

}catch(\Exception $e){

  return response()->json(['status'=>'error','message'=>'Oop`s something wents worng.']);
}
}

public function check_plan_type(Request $request){

 if(!is_null(CryptoPlan::find($request->id))){
   return CryptoPlan::find($request->id)->is_free;
}
}

}
