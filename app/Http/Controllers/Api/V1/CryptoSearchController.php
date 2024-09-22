<?php
namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserKey;
use App\Models\BlockchainAddressDetail;
use App\Models\BlockchainSearchResult;
use App\Models\CryptoPlanSubscription;
use App\Models\BlockchainAddressLabel;
use App\Models\BlockchainUserNote;
use App\Libraries\Blockcypher;
use App\Models\Port;
use App\Models\Attackers;
use App\Models\AttackerIp;
use App\Models\AttackType;
use App\Models\Country;
use App\Models\LiveAttacker;


class CryptoSearchController extends Controller
{

	public function getAddressOverview(Request $request){
		/* api call */

		$headers = $request->header('x-api-key');

		$user_keys = UserKey::with('users')->where(['key'=>$headers,'is_active'=>'Y'])->first();
		
		$user_info = $user_keys->users;
		$this->search_blockchain_by_keyword($request,$user_info);

		$data = BlockchainAddressDetail::select('balance','total_txn','first_seen_at','last_seen_at','total_received','total_sent','incoming_txn','outgoing_txn')->where('address',$request->keyword)->first();

		$status = true;

		return response()->json(['message' => 'Success','data' => $data,'status' => $status,'code'=>200]);

	}


	public function getRiskScore(Request $request){

		$headers = $request->header('x-api-key');

		$user_keys = UserKey::with('users')->where(['key'=>$headers,'is_active'=>'Y'])->first();
		
		$user_info = $user_keys->users;
		$this->search_blockchain_by_keyword($request,$user_info);

		$data = BlockchainSearchResult::select('anti_fraud')->where('address',$request->get('keyword'))->get();

		if(is_null($data)){

			return response()->json(['message' => 'Currently your have not any risk score','data' => '','status' => false,'code'=>404]);
		}

		$db['risk_level'] = [];

		foreach ($data as $key => $value) {

			if($value->anti_fraud->credit == 1){
				$db['risk_level'][] = 'Safe';

			}elseif($value->anti_fraud->credit == 2){
				$db['risk_level'][] = 'Risk';

			}elseif($value->anti_fraud->credit == 3){
				$db['risk_level'][] = 'Danger';

			}else{

				$db['risk_level'][] = 'Other';
			}

		}
		return response()->json(['message' => 'Success','data' => $db,'status' => true,'code'=>200]);

	}


	public function getAddressLabels(Request $request){

		$headers = $request->header('x-api-key');

		$user_keys = UserKey::with('users')->where(['key'=>$headers,'is_active'=>'Y'])->first();

		$user_info = $user_keys->users;
		$this->search_blockchain_by_keyword($request,$user_info);

		$keyword = $request->get('keyword');

		$data = $this->addressLabels($keyword);

		if(!is_null($data)){

			return response()->json(['message' => 'Success','data' => ['lables'=>$data],'status' => true,'code'=>200]);

		}else{

			return response()->json(['message' => 'Oop`s Currently you have not any labels','data' => '','status' => false,'code'=>404]);

		}
	}

	public function getUserFavourits(Request $request){

		$headers = $request->header('x-api-key');

		$user_keys = UserKey::with('users')->where(['key'=>$headers,'is_active'=>'Y'])->first();
		
		$user_info = $user_keys->users;
		$this->search_blockchain_by_keyword($request,$user_info);

		$user_keys = UserKey::with('users')->where(['key'=>$headers,'is_active'=>'Y'])->first();

		$user_info = $user_keys->users->id;

		$data = BlockchainUserNote::select('address','address_type as coin','description')->where('address',$request->keyword)->get();

		if(is_null($data) || count($data) < 1){

			return response()->json(['message' => 'Oop`s Currently you have not any favourits','data' => '','status' => false,'code'=>404]);

		}else{

			return response()->json(['message' => 'Success','data' => $data,'status' => true,'code'=>200]);

		}
	}

	public function getAddressProfileAnalysis(Request $request){

		$headers = $request->header('x-api-key');

		$user_keys = UserKey::with('users')->where(['key'=>$headers,'is_active'=>'Y'])->first();
		
		$user_info = $user_keys->users;
		$this->search_blockchain_by_keyword($request,$user_info);

		$keyword = $request->get('keyword');

		$new_array_labels = $this->addressLabels($keyword);

		$array_flip = array_flip($new_array_labels);  
		unset($array_flip['abuse']);
		unset($array_flip['ransomware']);
		unset($array_flip['ransom']);
		unset($array_flip['theft']);
		$array_flip_count = count($array_flip);

		$data = [

			'Theft'=>(in_array('theft',$new_array_labels) ? '1' : '0'),
			'Phishing'=>(in_array('phishing',$new_array_labels) ? '1' : '0'),
			'Ransom'=>((in_array('ransom',$new_array_labels) || in_array('ransomware',$new_array_labels) ) ? '1' : '0'),
			'Darknet Market'=>($array_flip_count > 0) ? '1' : '0',

		];

		return response()->json(['message' => 'Success','data' => $data,'status' => true,'code'=>200]);
	}


	public function addressLabels($keyword){

		$blockchain_search_result = BlockchainSearchResult::where('address',$keyword)->get();

		$labels = BlockchainAddressLabel::where('address',$keyword)->pluck('labels');

		$array_labels = [];

		foreach($blockchain_search_result as $value){

			if(count($value->labels)>0){

				foreach($value->labels as $key=>$labelsData){
					$array_labels[] =  $labelsData->id;    
				}
			}
		}

		if(!is_null($labels) AND count($labels) > 0){
			$or_array_labels = explode(',',$labels[0]);

			return $new_array_labels= array_merge($array_labels,$or_array_labels);

		}else{

			return $new_array_labels= $array_labels;

		}
	}

	public function getAddressDetails(Request $request){

		$headers = $request->header('x-api-key');
		$user_keys = UserKey::with('users')->where(['key'=>$headers,'is_active'=>'Y'])->first();
		$user_info = $user_keys->users;
		$address = $request->keyword;
		$this->search_blockchain_by_keyword($request,$user_info);

		$blockcypher = null;
		$obj_blockcypher = new Blockcypher();

		$blockcypher_details = $obj_blockcypher->details($address);
		if($blockcypher_details->status_code != 200){
			$blockcypher = null;
		}elseif(isset($blockcypher_details->response->message) && $blockcypher_details->response->message != ''){
			$blockcypher = null;
		}else{
			$blockcypher = $blockcypher_details->response;
		}

		if($blockcypher != null){
			$arr_txn = json_encode($blockcypher->transactions);
			return $arr_txn;
		}
	}


	public function getRandomCryptoAttacker(Request $request){
    
    $port = Port::inRandomOrder()->take(100)->pluck('port_no');
     
    $attackers_id = Attackers::inRandomOrder()->take(100)->pluck('id');
    $attackers = Attackers::inRandomOrder()->take(100)->pluck('name');

    $attackers_ip = AttackerIp::inRandomOrder()->take(100)->pluck('attacker_ip');
    $attackers_ip_id = AttackerIp::inRandomOrder()->take(100)->pluck('id');

    $attacker_type = AttackType::select('id','port','attaker_type')->inRandomOrder()->take(100)->get()->toArray();

    $attacker_type_id = AttackType::inRandomOrder()->take(100)->pluck('id');
    $attacker_port = AttackType::inRandomOrder()->take(100)->pluck('port');

    $country = Country::select('id','code','name')->inRandomOrder()->take(100)->get()->toArray();

    $country_id = Country::inRandomOrder()->take(100)->pluck('id');
    
    $live_attacker = LiveAttacker::select('timestamp','attacker','attacker_ip','attacker_geo','target_geo','attacker_type','port')->inRandomOrder()->take(50)->get()->toArray();

    return response()->json([
                    'attack_origins'=>$country,
                    'attacker_type' => $attacker_type,
                    'attackers_targets'=>$country,
                    'live_attacker'=>$live_attacker,
    	                    ]);
	}
}
?>