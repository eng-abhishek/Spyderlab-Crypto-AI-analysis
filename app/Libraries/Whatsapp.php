<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class Whatsapp
{
	private $wa_instance = '1101780973';
	private $apikey = 'abb4b7084281445e94f0904e9f203a9a1fd821d75fca45f68c';

	public function __construct(){
		$fb_credentials = app('api_services')['whatsapp'] ?? null;

		if($fb_credentials){
			$this->wa_instance = $fb_credentials['wa_instance'] ?? '';
			$this->apikey = $fb_credentials['apikey'] ?? '';
		}
	}

	public function get_details($phone_code, $phone_number){
		$whatsapp_exist = "";
		$avatar_url = "";
		$contact_info = "";

		/* Check whatsapp exist or not */
		$check_whatsapp = $this->checkWhatsapp($phone_code, $phone_number);
		if($check_whatsapp->status_code == 200){
			$whatsapp_exist = $check_whatsapp->response->existsWhatsapp;

			/* Get avatar url */
			$get_avatar = $this->getAvatar($phone_code, $phone_number);
			if($get_avatar->status_code == 200){
				$avatar_url = $get_avatar->response->urlAvatar;
			}

			/* Get Contact Info */
			$get_contact_info = $this->getContactInfo($phone_code, $phone_number);
			if($get_contact_info->status_code == 200){
				$contact_info = $get_contact_info->response;
			}
		}

		$response = json_encode([
			'status_code' => $check_whatsapp->status_code,
			'response' => [
				'whatsapp_exist' => $whatsapp_exist,
				'avatar_url' => $avatar_url,
				'contact_info' => $contact_info
			]
		]);

		return json_decode($response);
	}

	public function checkWhatsapp($phone_code, $phone_number){

		$phone_number = str_replace("+", "", $phone_code).$phone_number;

		$headers = array(
			'Content-Type: application/json'
		);

		$payload = json_encode(['phoneNumber' => $phone_number]);

		$ch = curl_init('https://api.green-api.com/waInstance'.$this->wa_instance.'/checkWhatsapp/'.$this->apikey);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);

		$response = json_encode([
			'status_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
			'response' => json_decode($result, true)
		]);

		curl_close($ch);

		return json_decode($response);
	}

	public function getAvatar($phone_code, $phone_number){

		$chatId = str_replace("+", "", $phone_code).$phone_number.'@c.us';

		$headers = array(
			'Content-Type: application/json'
		);

		$payload = json_encode(['chatId' => $chatId]);

		$ch = curl_init('https://api.green-api.com/waInstance'.$this->wa_instance.'/getAvatar/'.$this->apikey);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);

		$response = json_encode([
			'status_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
			'response' => json_decode($result, true)
		]);

		curl_close($ch);

		return json_decode($response);
	}

	public function getContactInfo($phone_code, $phone_number){

		$chatId = str_replace("+", "", $phone_code).$phone_number.'@c.us';

		$headers = array(
			'Content-Type: application/json'
		);

		$payload = json_encode(['chatId' => $chatId]);

		$ch = curl_init('https://api.green-api.com/waInstance'.$this->wa_instance.'/getContactInfo/'.$this->apikey);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);

		$response = json_encode([
			'status_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
			'response' => json_decode($result, true)
		]);

		curl_close($ch);

		return json_decode($response);
	}
}