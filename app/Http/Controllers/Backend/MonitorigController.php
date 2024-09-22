<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\MonitoringRequest;
use DataTables;
use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DB;
use Auth;

class MonitorigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if($request->ajax()) {
    		$data = Monitoring::with('users')->select('*');
    		return Datatables::of($data)
    		->addIndexColumn()
    		->addColumn('username', function($row){
    			return $row->users->username;
    		})
    		->addColumn('token', function($row){
    			return strtoupper($row->token);
    		})

    		->addColumn('email',function($row){

    			if($row->email != 'null'){

    				$email = json_decode($row->email,true);
    				return implode(', ', $email);

    			}else{
    				return 'NULL';
    			}
    		})
    		
    		->addColumn('created_at', function($row){
    			return $row->created_at->format('Y-m-d H:i:s');
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
    		->addColumn('action', function($row){
    			$btn = '';
    			$btn .= '<a href="'.route("backend.crypto-monitoring.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
    			$btn .= '<a href="javascript:;" data-url="'.route('backend.crypto-monitoring.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
    			return $btn;
    		})
    		->filter(function ($instance) use ($request) {
    			if ($request->get('status') != '') {
    				$instance->where('is_active', $request->get('status'));
    			}

    			if ($request->get('user') != '') {
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
    					$w->orWhere('token', 'LIKE', "%$search%");
    					$w->orwhereHas('users', function($query) use($search){
    						$query->where('username', 'LIKE', "%$search%");
    					});
    				});
    			}

    		})
    		->rawColumns(['email','username','token','created_at','is_active','action'])
    		->make(true);
    	}
    	$data['user_list']= User::where('is_admin','N')->get();

    	return view('backend.monitoring.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	
    	$data['user'] = User::where(['is_active'=>'Y','is_admin'=>'N'])->pluck('username','id');
    	return view('backend.monitoring.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MonitoringRequest $request)
    {
    	try{
    		
    		if($request->get('token') == 'BTC'){

    			$btc_pattern = "/\b((bc|tb)(0([ac-hj-np-z02-9]{39}|[ac-hj-np-z02-9]{59})|1[ac-hj-np-z02-9]{8,87})|([13]|[mn2])[a-km-zA-HJ-NP-Z1-9]{25,39})\b/";

    			if(preg_match($btc_pattern, $request->post('address')) == false){

    				return redirect()->route('backend.crypto-monitoring.create')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid BTC address.']);     
    			}

    		}elseif($request->get('token') == 'ETH'){

    			$eth_pattern  = "/^(0x){1}[0-9a-fA-F]{40}$/";

    			if(preg_match($eth_pattern, $request->post('address')) == false){

    				return redirect()->route('backend.crypto-monitoring.create')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid ETH address.']);     
    			}
    		}else{

    			return redirect()->route('backend.crypto-monitoring.create')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid ETH address.']);  

    		}
    		
    		$insert_arr = [
    			'user_id' => $request->post('user_id'),
    			'token' => $request->post('token'),
    			'address' => $request->post('address'),
    			'email' => json_encode($request->get('email_list')),
    			'description' => $request->post('description'),
    		];
         //Upload image
    		if($request->hasFile('logo')){

    			$document_path = 'address_logo';
    			if (!\Storage::exists($document_path)) {
    				\Storage::makeDirectory($document_path, 0777);
    			}

    			$filename = pathinfo($request->file('logo')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$request->file('logo')->getClientOriginalExtension();
    			$request->file('logo')->storeAs($document_path, $filename);

    			$insert_arr['logo'] = $filename;
    		}

    		Monitoring::create($insert_arr);

    		return redirect()->route('backend.crypto-monitoring.index')->with(['status' => 'success', 'message' => 'Monitoring has created successfully.']);

    	}catch(\Exception $e){

    		return redirect()->route('backend.crypto-monitoring.create')->with(['status' => 'danger', 'message' => 'Opp`s something went worng.']);
    	}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Monitorig  $monitorig
     * @return \Illuminate\Http\Response
     */
    // public function show(Monitorig $monitorig)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Monitorig  $monitorig
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$data['user'] = User::where(['is_active'=>'Y','is_admin'=>'N'])->pluck('username','id');
    	$data['record'] = Monitoring::find($id);

    	if($data['record']->email != 'null'){
    		$email = json_decode($data['record']->email);
    	}else{
    		$email = [];
    	}
    	$data['email'] = $email;

    	return view('backend.monitoring.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Monitorig  $monitorig
     * @return \Illuminate\Http\Response
     */
    public function update(MonitoringRequest $request,$id)
    {
    	DB::beginTransaction();
    	try{

    		if($request->get('token') == 'BTC'){

    			$btc_pattern = "/\b((bc|tb)(0([ac-hj-np-z02-9]{39}|[ac-hj-np-z02-9]{59})|1[ac-hj-np-z02-9]{8,87})|([13]|[mn2])[a-km-zA-HJ-NP-Z1-9]{25,39})\b/";

    			if(preg_match($btc_pattern, $request->post('address')) == false){

    				return redirect()->route('backend.crypto-monitoring.create')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid BTC address.']);     
    			}

    		}elseif($request->get('token') == 'ETH'){

    			$eth_pattern  = "/^(0x){1}[0-9a-fA-F]{40}$/";

    			if(preg_match($eth_pattern, $request->post('address')) == false){

    				return redirect()->route('backend.crypto-monitoring.create')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid ETH address.']);     
    			}
    		}else{

    			return redirect()->route('backend.crypto-monitoring.create')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid ETH address.']);  

    		}

    		$record = Monitoring::find($id);

    		$data = [
    			'user_id' => $request->post('user_id'),
    			'token' => $request->post('token'),
    			'address' => $request->post('address'),
    			'email' => json_encode($request->get('email_list')),
    			'description' => $request->post('description'),
    		];

             //Upload image
    		if($request->hasFile('logo')){

    			$document_path = 'address_logo';
    			if (!\Storage::exists($document_path)) {
    				\Storage::makeDirectory($document_path, 0777);
    			}

                //Remove old image
    			if ($record->logo != '' && \Storage::exists($document_path.'/'.$record->logo)) {
    				\Storage::delete($document_path.'/'.$record->logo);
    			}

    			$filename = pathinfo($request->file('logo')->getClientOriginalName(),
    				PATHINFO_FILENAME).'-'.time().'.'.$request->file('logo')->getClientOriginalExtension();
    			$request->file('logo')->storeAs($document_path, $filename);

    			$data['logo'] = $filename;
    		}

    		Monitoring::where('id',$id)->update(['email'=>'']);       
    		Monitoring::where('id',$id)->update($data);
    		DB::commit();
    		return redirect()->route('backend.crypto-monitoring.index')->with(['status' => 'success', 'message' => 'Monitoring has updated successfully.']);

    	}catch(\Exception $e){
    		DB::rollback();
    		return redirect()->route('backend.crypto-monitoring.update',$id)->with(['status' => 'danger', 'message' => 'Opp`s something went worng.']);
    	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Monitorig  $monitorig
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	try{
    		$del = Monitoring::find($id);

    		if($del){
    			if($del->is_active == 'Y'){
    				return response()->json(['status' => 'danger', 'message' => 'You can`t delete, because monitoring is active.']);    
    			}
    		}

    		$delID = Monitoring::findOrFail($id);
    		$delID->delete();
    		return response()->json(['status' => 'success', 'message' => 'Monitoring has deleted successfully.']);
    	}catch(\Exception $e){
    		return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }

    /*
     * Change the status
    */

    public function changeStatus(Request $request){

    	try{
    		$cryptoData=Monitoring::find($request->id);
    		$cryptoData->is_active=$request->is_active;
    		$cryptoData->save();
    		if($request->is_active=='Y'){

    			return response()->json(['status'=>'success','message'=>'Monitoring has activated successfully..']);    
    		}elseif($request->is_active=='N'){

    			return response()->json(['status'=>'success','message'=>'Monitoring has Inactivated successfully.']);
    		}

    	}catch(\Exception $e){

    		return response()->json(['status'=>'error','message'=>'Oop`s something wents worng.']);
    	}
    }

    public function sendVerifyEmail(Request $request){
    	
    	try{

    		$sender_email = $request->sender_email;
    		$otp = substr(md5(uniqid(rand(), true)), 5, 5);
    		$otp_start_time = Carbon::now();
    		
    		$otp_expiry = Carbon::now()->addSeconds(60);
    		
    		session()->put('sender_email',$sender_email);     
    		session()->put('otp_start_time',$otp_start_time);
    		session()->put('otp_expiry',$otp_expiry);
    		session()->put('otp',$otp);
    		
    		Mail::to([$sender_email])->send(new VerifyEmail($otp));
    		
    		return response()->json(['status'=>'success','message'=>'Verification code send successfully on your email.']);
    		
    	}catch(\Exception $e){

    		return response()->json(['status'=>'danger','message'=> 'Oop`s something went wrong try again later.']);
    	}

    }

    public function matchVerificationCode(Request $request){

    	try{

    		if(strtotime(session()->get('otp_expiry')) < strtotime(Carbon::now())){
    			
    			return response()->json(['status'=>'error','message'=>'Oop`s your verification code will expired.']);
    		}
    		
    		if(session()->get('otp') != $request->get('user_code')){

    			return response()->json(['status'=>'error','message'=>'Oop`s please enter valid verification code.']);
    		}
    		
    		return response()->json(['email'=>session()->get('sender_email'),'status'=>'success','message'=>'Your email verify successfully.']);

    	}catch(\Exception $e){

    		return response()->json(['status'=>'danger','message'=> 'Oop`s something went wrong try again later.']);
    	}    
    }

    public function resendEmail(){
    	
    	try{

    		$sender_email = session()->get('sender_email');
    		$otp = substr(md5(uniqid(rand(), true)), 5, 5);
    		$otp_expiry = Carbon::now()->addSeconds(60);
    		$otp_start_time = Carbon::now();
    		
    		session()->put('otp_start_time',$otp_start_time);
    		session()->put('otp_expiry',$otp_expiry);
    		session()->put('otp',$otp);
    		
    		Mail::to([$sender_email])->send(new VerifyEmail($otp));

    		return response()->json(['status'=>'success','message'=> 'Verification code send successfully on your email.']);

    	}catch(\Exception $e){
    		
    		return response()->json(['status'=>'danger','message'=> 'Oop`s something went wrong try again later.']);
    	}
    }

}
