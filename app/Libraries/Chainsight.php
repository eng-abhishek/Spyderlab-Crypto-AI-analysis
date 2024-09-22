<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class Chainsight
{
	public function details($keyword){

		$chainsight_credentials = app('api_services')['chainsight'];
		$apikey = $chainsight_credentials['apikey'] ?? '';

		$headers = array(
			'Content-Type: application/json',
			sprintf('X-API-KEY: %s', $apikey)
		);

		$ch = curl_init('https://api.chainsight.com/api/check?keyword='.$keyword);

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