<?php

namespace App\Libraries\PaymentGateways;

class CoinPayment {

	private $public_key;
	private $private_key;

	public function __construct() {
		
		$this->public_key = config('constants.coinpayment.public_key');
		$this->private_key = config('constants.coinpayment.private_key');
	}

	public function api_call($cmd, $req = array()) {

    // Set the API command and required fields
		$req['version'] = 1;
		$req['cmd'] = $cmd;
		$req['key'] = $this->public_key;
    	$req['format'] = 'json'; //supported values are json and xml

    // Generate the query string
    	$post_data = http_build_query($req, '', '&');

    // Calculate the HMAC signature on the POST data
    	$hmac = hash_hmac('sha512', $post_data, $this->private_key);

    // Create cURL handle and initialize (if needed)
    	static $ch = NULL;
    	if ($ch === NULL) {
    		$ch = curl_init('https://www.coinpayments.net/api.php');
    		curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    	}
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac));
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

    // Execute the call and close cURL handle
    	$data = curl_exec($ch);
    // Parse and return data if successful.
    	if ($data !== FALSE) {
    		if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
            // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
    			$dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
    		} else {
    			$dec = json_decode($data, TRUE);
    		}
    		if ($dec !== NULL && count($dec)) {
    			return $dec;
    		} else {
            // If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
    			return array('error' => 'Unable to parse JSON result ('.json_last_error().')');
    		}
    	} else {
    		return array('error' => 'cURL error: '.curl_error($ch));
    	}
    }

/**
 * Get Rates
 */
public function rates() {
	$rates = $this->api_call('rates', [
		'accepted' => 1
	]);

	return $rates;
}


/**
 * Create transaction
 *
 * @param Request $request
 * @return Json
 */
public function create_transaction($user, $plan_info, $amount, $currency1, $currency2) {

	$data = [
		'amount' => $amount,
		'currency1' => $currency1,
		'currency2' => $currency2,
		'buyer_email' => $user->email,
		'buyer_name' => $user->name,
		'item_name' => $plan_info->name,
		// 'ipn_url' => 
		'success_url' => route('checkout.success', 'crypto'),
		'cancel_url' => route('checkout.cancel', 'crypto'),
	];

	$response = $this->api_call('create_transaction', $data);
	return $response;
}

public function create_telegram_user_transaction($user, $plan_info, $amount, $currency1, $currency2) {

	$data = [
		'amount' => $amount,
		'currency1' => $currency1,
		'currency2' => $currency2,
		'buyer_email' => 'kipm1engg@gmail.com',
		'buyer_name' => $user->name,
		'item_name' => 'telegram_basic_plan',
		// 'ipn_url' => 
		// 'success_url' => route('checkout.success', 'crypto'),
		// 'cancel_url' => route('checkout.cancel', 'crypto'),
	];

	$response = $this->api_call('create_transaction', $data);
	return $response;
}


/**
 * Get Transaction Info
 */
public function get_tx_info($txn_id) {
	$info = $this->api_call('get_tx_info', [
		'txid' => $txn_id
	]);

	return $info;
}

}