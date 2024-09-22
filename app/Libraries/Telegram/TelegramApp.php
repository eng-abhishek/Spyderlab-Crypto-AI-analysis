<?php
namespace App\Libraries\Telegram;

use App\Models\BlockchainSearch;
use App\Models\BlockchainSearchResult;
use App\Http\Controllers\Controller;
use App\Models\TelegramUser;
use App\Models\BlockchainAddressDetail;

class TelegramApp{

	public function registerUser($userInfo){

		$CheckUser= TelegramUser::where('telegram_id',$userInfo['id'])->count();
		if($CheckUser < 1){

         if(isset($userInfo['last_name'])){
         	$last_name = $userInfo['last_name'];
         }else{
         	$last_name = '';
         }

			TelegramUser::Create([
				'telegram_id'=>$userInfo['id'],
				'name'=>$userInfo['first_name'].' '.$last_name,
				'username'=>$userInfo['username']
			]);

		}
	}


	public function getAddressDetails($address,$userInfo){

		$telegram_controller = new Controller();
		$userType = 'tg_user';
		$telegram_controller->search_blockchain_by_keyword(null,$userInfo,$address,$userType);

		$blockchain_search = BlockchainSearch::where('keyword', $address)->first();
		//dd($blockchain_search);
		if(!empty($blockchain_search)){

			$blockchain_search_result = BlockchainSearchResult::where('search_id', $blockchain_search->id)
			->first();

			/* START:Blockcypher */
			$blockcypher = [];

			$blockcypher_address_detail = BlockchainAddressDetail::where('search_id', $blockchain_search->id)->first();

			/* START:Temporary Code*/
			if(!$blockcypher_address_detail && $blockchain_search_result->address != ''){

				$telegram_controller->get_blockcypher_details($blockchain_search_result->address, $blockchain_search->id);

				$blockcypher_address_detail = BlockchainAddressDetail::where('search_id', $blockchain_search->id)->first();
			}
			/* END:Temporary Code*/
			if(!$blockcypher_address_detail){
				return array('status_code'=>401);
			}

			$blockcypher['address_details'] = $blockcypher_address_detail;

			$details = array(
				'keyword' => $address,
				'status_code' => $blockchain_search->status_code,
				'chainsight' => $blockchain_search_result,
				'blockcypher' => $blockcypher,
			);

		}else{
			$details = array(
				'keyword' => $address,
				'status_code' => null,
				'chainsight' => null,
				'blockcypher' => null,
			);
		}
		return $details;
	}

}