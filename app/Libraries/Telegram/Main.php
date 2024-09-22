<?php

namespace App\Libraries\Telegram;

use Illuminate\Support\Facades\Http;

class Main
{
	public function get_details($phone_code, $phone_number){
		
		$phone_number = $phone_code.$phone_number;

		$file = __dir__.'/Telegram.py';
		// exec("py ".$file." ".$phone_number." 2>&1", $output, $status); //Local
		exec("python3 ".$file." ".$phone_number." 2>&1", $output, $status); //Server
		
        $result = json_decode($output[0]);

        return $response = json_decode(json_encode([
			'status_code' => $result->status_code ?? '200',
			'response' => ['username' => $result->username ?? '']
		]));
	}
}