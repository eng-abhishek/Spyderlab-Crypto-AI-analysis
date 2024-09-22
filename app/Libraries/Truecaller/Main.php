<?php

namespace App\Libraries\Truecaller;

use Illuminate\Support\Facades\Http;

class Main
{
	public function truecaller_details($country_code, $phone_number){

		/* Get installation id */
		// $fileData = file_get_contents(__dir__.'/authkey.json');
		// $fileData = json_decode($fileData);

		// $trucaller_credentials = app('api_services')['truecaller'];
		// $authkey = $trucaller_credentials['authkey'] ?? '';
		// if($authkey != '' && \Storage::disk('local')->exists('api-services/'.$authkey)){
		// 	$fileData = \Storage::disk('local')->get('api-services/'.$authkey);
		// 	$fileData = json_decode($fileData);
		// }else{
		// 	$fileData = file_get_contents(__dir__.'/authkey.json');
		// 	$fileData = json_decode($fileData);
		// }

		$installation_id = '';
		
		$trucaller_credentials = app('api_services')['truecaller'];
		$authkey = $trucaller_credentials['authkey'] ?? '';
		if($authkey != '' && \Storage::disk('local')->exists('api-services/'.$authkey)){
			$fileData = \Storage::disk('local')->get('api-services/'.$authkey);
			$fileData = json_decode($fileData);
			$installation_id = $fileData->account->installations[0]->installation->id;
		}

		$headers = array(
			"Content-Type: application/json; charset=UTF-8",
			"Authorization: Bearer ".$installation_id,
		);

		$data = [
			'q' => $phone_number,
			'countryCode' => $country_code,
			'type' => 4,
			'locAddr' => '',
			'placement' => 'SEARCHRESULTS,HISTORY,DETAILS',
			'encoding' => 'json'
		];

		$url = sprintf("%s?%s", 'https://search5-noneu.truecaller.com/v2/search', http_build_query($data));

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);

		$response = [
			'status_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
			'response' => $result
		];

		curl_close($ch);

		return $response;
	}

		// function get_details($phone_number){

// 	$token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE2Njg3NTI4NDc2NjYsInRva2VuIjoiYTF3MDQtLVJzTkJ3ZUZBRm5BdmxWSXRyVjhxa2NncVhkLWF5UTNsbUgyUGFyTVpxeHBvRGpXM19fNllBUGd6cCIsImVuaGFuY2VkU2VhcmNoIjp0cnVlLCJjb3VudHJ5Q29kZSI6ImluIiwibmFtZSI6ImppZ25lc2hzaW5oIHJhdGhvZCIsImVtYWlsIjoiamlnbmVzaHNpbmgyMUBnbWFpbC5jb20iLCJpbWFnZSI6Imh0dHBzOi8vbGgzLmdvb2dsZXVzZXJjb250ZW50LmNvbS9hL0FMbTV3dTNHazQzUVZnOG1BUnZiTEw4MU1Xd1ZaX2ZLazctcHZqeGFmWWdrPXM5Ni1jIiwiaWF0IjoxNjY2MDc0NDQ3fQ.pKvBK8QZQpfE3IMLdPiAE67ZG4MMIcR5F6ICe8A382s';

// 	$headers = array(
// 		'Content-Type: application/json',
// 		sprintf('Authorization: %s', $token)
// 	);

// 	$curl = curl_init('https://asia-south1-truecaller-web.cloudfunctions.net/api/noneu/search/v1?q='.$phone_number.'&countryCode=in');

// 	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// 	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// 	$result = json_decode(curl_exec($curl));

// 	return $result;
// }
}