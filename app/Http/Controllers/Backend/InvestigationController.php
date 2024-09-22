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
use App\Libraries\Blockcypher;
use App\Models\BlockchainSearch;
use App\Models\BlockchainAddressDetail;
use App\Models\BlockchainAddressTxn;
use App\Models\BlockchainAddressTxnInout;
use App\Models\BlockchainSearchResult;
use App\Models\BlockchainAddressLabel;

class InvestigationController extends Controller
{
	public function index(Request $request){
		if($request->get('keyword') && $request->get('token')){

             /* api call */
            $this->search_blockchain_by_keyword($request);

			$blockchain_search = \App\Models\BlockchainSearch::where('keyword', $request->get('keyword'))->first();

			if(!$blockchain_search){
				return response()->json(['status' => 'danger', 'message' => 'Record not found for this keyword']);
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
				->take(10)
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
			return view('backend.investigation.investigation_graph',$data);
		}else{
			return view('backend.investigation.index');
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
		->paginate(20);

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
		$json_array = array('blockcypher_txn_receiver'=>$blockcypher_txn_receiver,'data_receiver'=>$json_arr,'orginal_data'=>$orginal_data,'status' => 'success');

		$address = $request->get('keyword');

		return response()->json(array('address'=>$address,'data_receiver'=>$json_arr,'status' => 'success', 'html' => view('backend.layouts.partials.receiver_tree_graph_pagination',$json_array)->render()));
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
		->paginate(20);

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

		return response()->json(array('address'=>$address,'data_sender'=>$arr_sender,'status' => 'success', 'html' => view('backend.layouts.partials.sender_tree_graph_pagination',$json_array)->render()));
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
		->paginate(10);

		return view('backend.layouts.partials.receiver_common_txn',['blockcypher_txn_receiver'=>$blockcypher_txn_receiver,'currency'=>$currency]);
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
		->paginate(10);

		return view('backend.layouts.partials.sender_common_txn',['blockcypher_txn_sender'=>$blockcypher_txn_sender,'currency'=>$currency]);

	}
}
?>