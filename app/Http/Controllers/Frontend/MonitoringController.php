<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MonitoringRequest;
use App\Models\Monitoring;
use App\Models\User;
use App\Mail\BlockChainTxnEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Libraries\Blockcypher;
use DB;
use Auth;
use App;
use DataTables;

class MonitoringController extends Controller
{
	
	public function __construct() {
		$this->middleware(['auth','verified']);
	}

	public function index(){
		   return view('frontend.account.monitoring');
	}

	public function getTableData(Request  $request){
		if(!is_null($request->get('token')) || !is_null($request->get('status'))){

			$status = $request->get('status');
			$token = $request->get('token');

			$query = Monitoring::select("*")
			->where('user_id',Auth()->user()->id);

			$result = $query->where(function($q) use ($status,$token){
				
				if(!empty($status) && !empty($token)){
					$q->where('is_active',$status);
					$q->where('token',$token);

				}elseif(!empty($status)){
					
					$q->where('is_active',$status);
					
				}else{
					
					$q->where('token',$token);
					
				}
			})->paginate(10);

			$data['result'] = $result;

		}else{

			$data['result'] = Monitoring::where('user_id',Auth()->user()->id)->paginate(10);
		}
		return view('frontend.partials.monitoring-table',$data);
	}

	public function store(MonitoringRequest $request)
	{
		try{

           /* Check User Subscription */
          
         $response = $this->check_user_subscription();
         if(!is_null($response)){
             return redirect()->route($response['route'])->with(['status'=>$response['status'],'message'=>$response['message']]);
         }

            /*  End User Subscription */

			if($request->get('token') == 'BTC'){

				$btc_pattern = "/\b((bc|tb)(0([ac-hj-np-z02-9]{39}|[ac-hj-np-z02-9]{59})|1[ac-hj-np-z02-9]{8,87})|([13]|[mn2])[a-km-zA-HJ-NP-Z1-9]{25,39})\b/";

				if(preg_match($btc_pattern, $request->post('address')) == false){

					return redirect()->route('monitoring.index')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid BTC address.']);     
				}

			}elseif($request->get('token') == 'ETH'){

				$eth_pattern  = "/^(0x){1}[0-9a-fA-F]{40}$/";

				if(preg_match($eth_pattern, $request->post('address')) == false){

					return redirect()->route('monitoring.index')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid ETH address.']);     
				}
			}else{

				return redirect()->route('monitoring.index')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid ETH address.']);  

			}

			$insert_arr = [
				'user_id' => Auth()->user()->id,
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

			return redirect()->route('monitoring.index')->with(['status' => 'success', 'message' => 'Monitoring has created successfully.']);

		}catch(\Exception $e){

			return redirect()->route('monitoring.index')->with(['status' => 'danger', 'message' => 'Opp`s something went worng.']);
		}
	}


	public function edit($id)
	{

		$data['record'] = Monitoring::find($id);

		if($data['record']->email != 'null'){
			$email = json_decode($data['record']->email);
		}else{
			$email = [];
		}
		$data['email'] = $email;
		return view('frontend.partials.monitoring-edit-form',$data);
	}

	public function update(MonitoringRequest $request,$id)
	{
		DB::beginTransaction();
		try{

          /* Check User Subscription */

         $response = $this->check_user_subscription();
         if(!is_null($response)){
             return redirect()->route($response['route'])->with(['status'=>$response['status'],'message'=>$response['message']]);
         }
         
            /*  End User Subscription */

			if($request->get('token') == 'BTC'){

				$btc_pattern = "/\b((bc|tb)(0([ac-hj-np-z02-9]{39}|[ac-hj-np-z02-9]{59})|1[ac-hj-np-z02-9]{8,87})|([13]|[mn2])[a-km-zA-HJ-NP-Z1-9]{25,39})\b/";

				if(preg_match($btc_pattern, $request->post('address')) == false){

					return redirect()->route('monitoring.index')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid BTC address.']);     
				}

			}elseif($request->get('token') == 'ETH'){

				$eth_pattern  = "/^(0x){1}[0-9a-fA-F]{40}$/";

				if(preg_match($eth_pattern, $request->post('address')) == false){

					return redirect()->route('monitoring.index')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid ETH address.']);     
				}
			}else{

				return redirect()->route('monitoring.index')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid ETH address.']);  

			}
			
			$record = Monitoring::find($id);

			$data = [
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
			return redirect()->route('monitoring.index')->with(['status' => 'success', 'message' => 'Monitoring has updated successfully.']);

		}catch(\Exception $e){
			DB::rollback();
			return redirect()->route('monitoring.index')->with(['status' => 'danger', 'message' => 'Opp`s something went worng.']);
		}
	}


	public function destroy($id)
	{
		try{
			$del = Monitoring::find($id);

			if($del){
				if($del->is_active == 'Y'){

					return redirect()->route('monitoring.index')->with(['status' => 'danger', 'message' => 'You can`t delete, because monitoring is active.']);

				}
			}

			$delID = Monitoring::findOrFail($id);
			$delID->delete();

			return redirect()->route('monitoring.index')->with(['status' => 'success', 'message' => 'Monitoring has deleted successfully.']);

		}catch(\Exception $e){

			return redirect()->route('monitoring.index')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);

		}
	}

	public function status(Request $request){
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

			return response()->json(['status'=>'danger','message'=>'Oop`s something wents worng.']);
		}
	}
}
