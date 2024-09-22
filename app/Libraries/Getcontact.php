<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class Getcontact
{
	public function details($contact_no){

		$curl = curl_init();

		curl_setopt_array($curl, array(
    CURLOPT_URL => "https://pakistandatabase.com/Api/OtherSites/PakistanDatabase/79r739nr3r99mr.php?number=".$contact_no."",// your preferred link
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_TIMEOUT => 30000,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        // Set Here Your Requesred Headers
    	'Content-Type: application/json',
    ),
));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			return json_decode($response);
		}

	}
}