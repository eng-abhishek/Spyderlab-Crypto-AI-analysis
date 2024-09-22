<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class Numverify
{
	public function numverify_details($phone_code, $phone_number){

		// $token = 'g98iOZgV45aD8lCEfcP9bmFmCK2TZ0Ed';
		$numverify_credentials = app('api_services')['numverify'];
		$apikey = $numverify_credentials['apikey'] ?? '';

		$phone_number = $phone_code.$phone_number;

		$headers = array(
			'Content-Type: application/json',
			sprintf('apikey: %s', $apikey)
		);

		$ch = curl_init('https://api.apilayer.com/number_verification/validate?number='.$phone_number);

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
}