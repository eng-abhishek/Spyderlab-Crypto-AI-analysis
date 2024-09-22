<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CryptoPlanSubscription;
use App\Models\User;
use App\Models\Plan;
use App\Models\CryptoPlan;
use App\Models\CryptoPlanTransaction;
use App\Models\Investigation;
use Carbon\Carbon;
use App\Http\Requests\InvestigationRequest;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Libraries\Blockcypher;
use App\Models\BlockchainSearch;
use App\Models\BlockchainAddressDetail;
use App\Models\BlockchainAddressTxn;
use App\Models\BlockchainAddressTxnInout;
use App\Models\BlockchainSearchResult;
use App\Models\BlockchainAddressLabel;
use Auth;

class InvestigationController extends Controller
{

	public function __construct() {
		$this->middleware(['auth','verified']);
	}

	public function index(){
		$chk_user_sub = CryptoPlanSubscription::whereHas('plans',function($q){
			$q->where('is_free','N');
		})
		->where('user_id',Auth::user()->id)
		->count();
		return view('frontend.account.investigation',['chk_user_sub'=>$chk_user_sub]);
	}

	public function getTableData(Request  $request){

		if(!is_null($request->get('token')) || !is_null($request->get('status'))){

			$status = $request->get('status');
			$token = $request->get('token');
			
			$query = Investigation::select("*")
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

			$data['result'] = Investigation::where('user_id',Auth()->user()->id)->paginate(10);
		}

		return view('frontend.partials.investigation.table',$data);
	}

	public function store(InvestigationRequest $request)
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

					return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid BTC address.']);     
				}

			}elseif($request->get('token') == 'ETH'){

				$eth_pattern  = "/^(0x){1}[0-9a-fA-F]{40}$/";

				if(preg_match($eth_pattern, $request->post('address')) == false){

					return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid ETH address.']);     
				}
			}else{

				return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid ETH address.']);  

			}

			$insert_arr = [
				'user_id' => Auth()->user()->id,
				'token' => $request->post('token'),
				'address' => $request->post('address'),
				'description' => $request->post('description'),
			];


			Investigation::create($insert_arr);

			return redirect()->route('investigation.index')->with(['status' => 'success', 'message' => 'Investigation has created successfully.']);

		}catch(\Exception $e){

			return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Opp`s something went worng.']);
		}
	}

	public function edit($id)
	{
          
          /* Check User Subscription */

         $response = $this->check_user_subscription();
         if(!is_null($response)){
             return redirect()->route($response['route'])->with(['status'=>$response['status'],'message'=>$response['message']]);
         }
         
            /*  End User Subscription */

		$data['record'] = Investigation::find($id);
		return view('frontend.partials.investigation.edit-form',$data);
	}

	public function update(Request $request,$id)
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

					return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid BTC address.']);     
				}

			}elseif($request->get('token') == 'ETH'){

				$eth_pattern  = "/^(0x){1}[0-9a-fA-F]{40}$/";

				if(preg_match($eth_pattern, $request->post('address')) == false){

					return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid ETH address.']);     
				}
			}else{

				return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Opp`s please enter valid ETH address.']);  

			}
			
			$record = Investigation::find($id);

			$data = [
				'token' => $request->post('token'),
				'address' => $request->post('address'),
				'description' => $request->post('description'),
			];

			Investigation::where('id',$id)->update($data);

			return redirect()->route('investigation.index')->with(['status' => 'success', 'message' => 'Investigation has updated successfully.']);

		}catch(\Exception $e){
			
			return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Opp`s something went worng.']);
		}
	}


	public function destroy($id)
	{
		try{
			$del = Investigation::find($id);

			if($del){
				if($del->is_active == 'Y'){

					return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'You can`t delete, because investigation is active.']);

				}
			}

			$delID = Investigation::findOrFail($id);
			$delID->delete();

			return redirect()->route('investigation.index')->with(['status' => 'success', 'message' => 'Monitoring has deleted successfully.']);

		}catch(\Exception $e){

			return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);

		}
	}

	public function status(Request $request){
		try{

			$cryptoData=Investigation::find($request->id);
			$cryptoData->is_active=$request->is_active;
			$cryptoData->save();
			if($request->is_active=='Y'){

				return response()->json(['status'=>'success','message'=>'Investigation has activated successfully..']);    
			}elseif($request->is_active=='N'){

				return response()->json(['status'=>'success','message'=>'Investigation has Inactivated successfully.']);
			}

		}catch(\Exception $e){

			return response()->json(['status'=>'danger','message'=>'Oop`s something wents worng.']);
		}
	}

	public function graph_index(Request $request){
		
		if($request->get('keyword') && $request->get('token')){

			/* START:Temporary solution */
			$has_access = false;
			if(Auth::check()){
				$has_access = true;
				if(is_null(Auth::user()->email_verified_at)){
					return redirect('email/verify');
				}elseif(is_null(Auth::user()->kyc_verified_at)){
					return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Your account is disabled for this service. It will be enabled after ID verification. Please contact us at '.config('mail.kyc_verification_mail').'.']);
				}
			}

			if(!$has_access){

				return redirect()->route('login');    
			}
            // dd('3');
			/* END:Temporary solution */
            /*
            $available_credits = available_credits();
            if($available_credits == 0){
                return redirect()->route('blockchain-analysis')->with(['status' => 'danger', 'message' => 'You doesn\'t have enough credit, please buy it from &nbsp;<a href="'.route('pricing').'">Pricing</a>']);
            }
            */
            
            /* Check User Subscription */
            $available_plan = available_plan();
            // dd($available_plan);
            
            if($available_plan == 'No Sub'){
            	
            	return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' =>'Oop`s you can not enjoy this feature without any subscription']);
            }

            if($available_plan == 'No Active Sub'){
            	
            	return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Oop`s  your current subscription deactivated by admin']);
            }

            if($available_plan == 'Expired Sub'){
            	
            	return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Oop`s your current subscription has expired']);
            }

            /* Check paid plan */
            
            $chk_user_sub = CryptoPlanSubscription::whereHas('plans',function($q){
            	$q->where('is_free','N');
            })
            ->where('user_id',Auth::user()->id)
            ->count();
            
            if($chk_user_sub < 1){
            	
            	return redirect()->route('investigation.index')->with(['status' => 'danger', 'message' => 'Oop`s this features available only for paid users, <a class="text-white" href="'.route("pricing").'">Click Here</a>']);
            }

            /*  End User Subscription */

            /* api call */
            $this->search_blockchain_by_keyword($request);
            
            $blockchain_search = \App\Models\BlockchainSearch::where('keyword', $request->get('keyword'))->first();
            
            if(!$blockchain_search){
            	return response()->json(['status' => 'danger', 'message' => 'Record not found for this address']);
            }

            $blockchain_search_result = BlockchainSearchResult::where('search_id', $blockchain_search->id)
            ->first();

            $blockcypher_address_detail = BlockchainAddressDetail::where('search_id', $blockchain_search->id)->first();
            if(!$blockcypher_address_detail){
            	return response()->json(['status' => 'danger', 'message' => 'Receiver record not found for this address']);
            }

            $currency = $blockcypher_address_detail->currency;

            if(!$blockchain_search_result){

            	return response()->json(['status' => 'danger', 'message' => 'Record not found for this address']);
            }

            /* START:Blockcypher */
            $blockcypher = [];

            $blockcypher_address_detail = BlockchainAddressDetail::where('search_id', $blockchain_search->id)->first();

            /* START:Temporary Code*/
            if(!$blockcypher_address_detail && $blockchain_search_result->address != ''){
            	$this->get_blockcypher_details($blockchain_search_result->address, $blockchain_search->id);

            	$blockcypher_address_detail = BlockchainAddressDetail::where('search_id', $blockchain_search->id)->first();
            }
            /* END:Temporary Code*/

            if($blockcypher_address_detail){
            	$blockcypher['address_details'] = $blockcypher_address_detail;

            	$monthly_transactions = BlockchainAddressTxn::select(\DB::raw('DATE_FORMAT(confirmed_at, "%b-%y") as name'), \DB::raw('count(*) as y'))
            	->where('address_detail_id', $blockcypher_address_detail->id)
            	->groupBy('name')
            	->orderBy('confirmed_at', 'asc')
            	->take(5)
            	->get();

            	$blockcypher['monthly_txn_chart_data'] = json_encode($monthly_transactions->toArray());
            }
            /* END:Blockcypher */

            $labels = BlockchainAddressLabel::where('address',$request->get('keyword'))->pluck('labels');

            $array_labels = [];

            if(count($blockchain_search_result->labels)>0){
            	foreach($blockchain_search_result->labels as $key=>$labelsData){
            		$array_labels[] =  $labelsData->id;    
            	}
            }

            if(!is_null($labels) AND count($labels) > 0){
            	$or_array_labels = explode(',',$labels[0]);
            	$new_array_labels= array_merge($array_labels,$or_array_labels);
            }else{
            	$new_array_labels= $array_labels;
            }

            $data['currency'] = strtoupper($currency);
            $data['address'] = $request->get('keyword');
            $data['blockcypher'] = $blockcypher;
            $data['new_array_labels'] = (isset($new_array_labels) ? $new_array_labels : array());
            $data['credit']= $blockchain_search_result->anti_fraud->credit;
			//dd($data);
            return view('frontend.account.investigation-graph',$data);
        }else{
        	return view('frontend.account.investigation');
        }
    }

    public function getReceiverGraph(Request $request){

    	/* api call */
    	$this->search_blockchain_by_keyword($request);

    	$blockchain_search = \App\Models\BlockchainSearch::where('keyword', $request->get('keyword'))->first();

    	if(!$blockchain_search){
    		return response()->json(['status' => 'danger', 'message' => 'Receiver record not found for this address']);
    	}

    	$blockcypher_address_detail = BlockchainAddressDetail::where('search_id', $blockchain_search->id)->first();
    	if(!$blockcypher_address_detail){
    		return response()->json(['status' => 'danger', 'message' => 'Receiver record not found for this address']);
    	}

    	$currency = $blockcypher_address_detail->currency;

    	$blockcypher_txn_receiver = BlockchainAddressTxnInout::Select('from', 'to', \DB::raw('COUNT(DISTINCT txn_id) AS txn'), \DB::raw('SUM(amount) AS amount'))
    	->where('from', $request->get('keyword'))
    	->groupBy('to')
    	->paginate(5);

    	$orginal_data = collect($blockcypher_txn_receiver);
    	$data = $orginal_data['data'];

    	if(count($data)<1){
    		return response()->json(['status' => 'danger', 'message' => 'Receiver record not found for this address']);
    	}

    	if(isset($data[0]['amount'])){
    		$amount = round($data[0]['amount']/config('constants.blockcypher.amount.'.$currency), 4).' '.strtoupper($currency);
    	}else{
    		$amount = 0;
    	}

    	if($currency == 'eth'){
    		$parent = strtolower($request->get('keyword'));
    	}else{
    		$parent = $request->get('keyword');
    	}

    	$arr[] = ['name'=>$amount,'id'=>$parent,'parent'=>''];

    	foreach ($data as $key => $value) {
    		if($value['to'] == $value['from']){

    		}else{

    			$amount = round($value['amount']/config('constants.blockcypher.amount.'.$currency), 4).' '.strtoupper($currency);

    			$arr[] = ['name'=>$amount,'id'=>$value['to'],'parent'=>$value['from']];
    		}
    	}

    	$json_arr = collect($arr)->toArray();
        // dd(json_encode($json_arr));
        // die;
    	$json_array = array('blockcypher_txn_receiver'=>$blockcypher_txn_receiver,'data_receiver'=>$json_arr,'orginal_data'=>$orginal_data,'status' => 'success');

    	$address = $request->get('keyword');

    	return response()->json(array('address'=>$address,'data_receiver'=>$json_arr,'status' => 'success', 'html' => view('frontend.partials.investigation.receiver_tree_graph_pagination',$json_array)->render()));
    }

    public function getSenderGraph(Request $request){
    	
    	/* api call */
    	$this->search_blockchain_by_keyword($request);

    	$blockchain_search = \App\Models\BlockchainSearch::where('keyword', $request->get('keyword'))->first();

    	if(!$blockchain_search){
    		return response()->json(['status' => 'danger', 'message' => 'Sender record not found for this address']);
    	}

    	$blockcypher_address_detail = BlockchainAddressDetail::where('search_id', $blockchain_search->id)->first();
    	if(!$blockcypher_address_detail){
    		return response()->json(['status' => 'danger', 'message' => 'Sender record not found for this address']);
    	}

    	$currency = $blockcypher_address_detail->currency;

    	$blockcypher_txn_sender = BlockchainAddressTxnInout::Select('from', 'to', \DB::raw('COUNT(DISTINCT txn_id) AS txn'), \DB::raw('SUM(amount) AS amount'))
    	->where('to', $request->get('keyword'))
    	->groupBy('from')
    	->paginate(5);

    	$org_data_sender = collect($blockcypher_txn_sender);

    	$data_sender = $org_data_sender['data'];

    	if(count($data_sender)<1){
    		return response()->json(['status' => 'danger', 'message' => 'Sender record not found for this address']);
    	}

    	$amount = round($data_sender[0]['amount']/config('constants.blockcypher.amount.'.$currency), 4).' '.strtoupper($currency);

    	if($currency == 'eth'){
    		$parent = strtolower($request->get('keyword'));
    	}else{
    		$parent = $request->get('keyword');
    	}

    	$data_sender_array[] = ['name'=>$amount,'id'=>$parent,'parent'=>''];	
    	
    	foreach ($data_sender as $key => $value) {
    		if($value['to'] == $value['from']){

    		}else{

    			$amount = round($value['amount']/config('constants.blockcypher.amount.'.$currency), 4).' '.strtoupper($currency);

    			$data_sender_array[] = ['name'=>$amount,'id'=>$value['from'],'parent'=>$value['to']];
    		}
    	}

    	$arr_sender = collect($data_sender_array)->toArray();

    	$json_array = array('blockcypher_txn_sender'=>$blockcypher_txn_sender,'data_sender'=>$arr_sender,'status' => 'success');

    	$address = $request->get('keyword');

    	return response()->json(array('address'=>$address,'data_sender'=>$arr_sender,'status' => 'success', 'html' => view('frontend.partials.investigation.sender_tree_graph_pagination',$json_array)->render()));
    }


    public function getReceiverCommonTxn(Request $request){

    	$blockchain_search = \App\Models\BlockchainSearch::where('keyword', $request->get('address'))->first();

    	if(!$blockchain_search){
    		return response()->json(['status' => 'danger', 'message' => 'Receiver record not found for this address']);
    	}

    	$blockcypher_address_detail = BlockchainAddressDetail::where('search_id', $blockchain_search->id)->first();
    	if(!$blockcypher_address_detail){
    		return response()->json(['status' => 'danger', 'message' => 'Receiver record not found for this address']);
    	}

    	$currency = $blockcypher_address_detail->currency;

    	$blockcypher_txn_receiver = BlockchainAddressTxnInout::Select('id','from', 'to', \DB::raw('COUNT(DISTINCT txn_id) AS txn'), \DB::raw('SUM(amount) AS amount'))
    	->where('from', $request->get('address'))
    	->groupBy('to')
    	->having('txn','>',1)
    	->paginate(5);

    	return view('frontend.partials.investigation.receiver_common_txn',['blockcypher_txn_receiver'=>$blockcypher_txn_receiver,'currency'=>$currency]);
    }

    public function getSenderCommonTxn(Request $request){

    	$blockchain_search = \App\Models\BlockchainSearch::where('keyword', $request->get('address'))->first();

    	if(!$blockchain_search){
    		return response()->json(['status' => 'danger', 'message' => 'Sender record not found for this address']);
    	}

    	$blockcypher_address_detail = BlockchainAddressDetail::where('search_id', $blockchain_search->id)->first();
    	if(!$blockcypher_address_detail){
    		return response()->json(['status' => 'danger', 'message' => 'Sender record not found for this address']);
    	}

    	$currency = $blockcypher_address_detail->currency;

    	$blockcypher_txn_sender = BlockchainAddressTxnInout::Select('id','from', 'to', \DB::raw('COUNT(DISTINCT txn_id) AS txn'), \DB::raw('SUM(amount) AS amount'))
    	->where('to', $request->get('address'))
    	->groupBy('from')
    	->having('txn','>','1')
    	->paginate(5);

    	return view('frontend.partials.investigation.sender_common_txn',['blockcypher_txn_sender'=>$blockcypher_txn_sender,'currency'=>$currency]);

    }

}
?>