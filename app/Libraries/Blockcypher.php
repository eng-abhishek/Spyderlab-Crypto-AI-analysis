<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class Blockcypher
{
	public function get_detail_by_address($address, $before = null){

		$currency = get_currency_from_address($address);

		$headers = array(
			'Content-Type: application/json'
		);

		$url = 'https://api.blockcypher.com/v1/'.$currency.'/main/addrs/'.$address.'/full?limit=50';
		if(!is_null($before)){
			$url .= '&before='.$before;
		}

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


		$result = curl_exec($ch);

		$response = json_encode([
			'status_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
			'response' => json_decode($result,true)
		]);

		curl_close($ch);

		return json_decode($response);
	}

	public function details($address){

		$result = $this->get_detail_by_address($address);

		if($result->status_code != 200){
			return $result;
		}

		$response = $result->response;

		$address_details = [
			'currency' => get_currency_from_address($response->address),
			'address' => $response->address,
			'total_received' => $response->total_received,
			'total_sent' => $response->total_sent,
			'balance' => $response->final_balance,
			'total_txn' => $response->final_n_tx,
			'incoming_txn' => 0,
			'outgoing_txn' => 0,
			'first_seen_at' => null,
			'last_seen_at' => null
		];

		$transactions = [];
		$inouts = [];

		if($address_details['total_txn'] <= config('constants.blockcypher.address_txn_limit')){
			$this->recursive_details($response, $address_details, $transactions, $inouts);

			//Update total_txn with actual transaction
			$address_details['total_txn'] = count($transactions);
			$address_details['incoming_txn'] = ($address_details['incoming_txn'] > $address_details['total_txn']) ? $address_details['total_txn'] : $address_details['incoming_txn']; // Temporary solution
			$address_details['outgoing_txn'] = $address_details['total_txn'] - $address_details['incoming_txn'];

			if($address_details['total_txn'] == 0){
				$address_details['first_seen_at'] = null;
				$address_details['last_seen_at'] = null;
			}elseif($address_details['total_txn'] == 1){
				$address_details['first_seen_at'] = $transactions[0]['confirmed_at'];
				$address_details['last_seen_at'] = $transactions[0]['confirmed_at'];
			}else{
				$address_details['first_seen_at'] = $transactions[count($transactions)-1]['confirmed_at'];
				$address_details['last_seen_at'] = $transactions[0]['confirmed_at'];
			}
		}

		$address_details['transactions'] = $transactions;
		$address_details['inouts'] = $inouts;

		return json_decode(json_encode([
			'status_code' => $result->status_code,
			'response' => $address_details
		]));

	}	

	public function recursive_details($response, &$address_details, &$transactions, &$inouts){

		$inout_address = $response->address;
		$currency = get_currency_from_address($response->address);
		if($currency == 'eth'){
			$inout_address = strtolower(ltrim($response->address, '0x'));
		}

		$txn_index = count($transactions) - 1;
		foreach($response->txs as $txn){
			$txn_index++;
			$transactions[$txn_index] = [
				'txn_id' => $txn->hash,
				'block_hash' => $txn->block_hash ?? '',
				'block_height' => $txn->block_height,
				'amount' => $txn->total,
				'fees' => $txn->fees,
				'confirmed_at' => isset($txn->confirmed) ? date('Y-m-d H:i:s', strtotime($txn->confirmed)) : ''
			];

			foreach($txn->inputs as $input){
				if(!is_null($input->addresses)){
					$inout_arr['txn_id'] = $txn->hash;
					$inout_arr['from'] = ($currency == 'eth') ? '0x'.$input->addresses[0]: $input->addresses[0];

					foreach($txn->outputs as $output){
						if(!is_null($output->addresses)){
							$inout_arr['amount'] = $output->value;
							$inout_arr['to'] = ($currency == 'eth') ? '0x'.$output->addresses[0]: $output->addresses[0];

							if($input->addresses[0] == $inout_address || $output->addresses[0] == $inout_address){
								if(collect($inouts)->where('txn_id', $txn->hash)->where('from', $input->addresses[0])->count() == 0){
									$inouts[] = $inout_arr;
								}
							}
						}
					}
				}
			}

			$inputs = [];
			foreach($txn->inputs as $input){
				if(!is_null($input->addresses)){
					$inputs[] = [
						'txn_script_type' => $input->script_type ?? '',
						'txn_script' => $input->script ?? '',
						'address' => ($currency == 'eth') ? '0x'.($currency == 'eth') :$input->addresses[0],
						'amount' => $input->output_value ?? 0
					];
				}
			}
			$transactions[$txn_index]['inputs'] = $inputs;

			$outputs = [];
			foreach($txn->outputs as $output){
				if(!is_null($output->addresses)){
					$outputs[] = [
						'txn_script_type' => $output->script_type ?? '',	
						'txn_script' => $output->script ?? '',
						'address' => ($currency == 'eth') ? '0x'.$output->addresses[0] : $output->addresses[0],
						'amount' => $output->value ?? 0
					];

					if($output->addresses[0] == $inout_address){
						$address_details['incoming_txn']++;
					}
				}
			}
			$transactions[$txn_index]['outputs'] = $outputs;
		}
		
		if(count($transactions) < $response->final_n_tx && count($response->txs) > 0){

			$results = $this->get_detail_by_address($response->address, $response->txs[count($response->txs)-1]->block_height);

			$this->recursive_details($results->response, $address_details, $transactions, $inouts);
		}
	}
}