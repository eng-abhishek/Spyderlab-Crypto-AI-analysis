<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class Facebook
{
	private $e_auth_v = 'e1';
	private $e_auth = 'abdf8d61-68f0-4fc1-8f85-810d603560d3';
	private $e_auth_c = '36';
	private $e_auth_k = 'PdftSBeR0MhnR7fO';
	private $user_agent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148';

	public function __construct(){
		$fb_credentials = app('api_services')['facebook'];

		$this->e_auth_v = $fb_credentials['e_auth_v'] ?? '';
		$this->e_auth = $fb_credentials['e_auth'] ?? '';
		$this->e_auth_c = $fb_credentials['e_auth_c'] ?? '';
		$this->e_auth_k = $fb_credentials['e_auth_k'] ?? '';
	}

	public function get_url($phone_code, $phone_number){

		$phone_number = str_replace("+", "", $phone_code).$phone_number;

		$headers = array(
			"e-auth-v: ".$this->e_auth_v,
			"e-auth: ".$this->e_auth,
			"e-auth-c: ".$this->e_auth_c,
			"e-auth-k: ".$this->e_auth_k,
			// "User-Agent: ".$this->user_agent,
			"User-Agent: ".$_SERVER['HTTP_USER_AGENT'],
			"Connection: Keep-Alive",
			"Accept-Encoding: gzip"
		);

		$data = [
			'cli' => $phone_number,
			'is_callerid' => false,
			'size' => "small",
			'type' => 0,
			'cancelfresh' => 1,
			'cv' => 'vc_416_vn_3.0.416_a'
		];

		$url = sprintf("%s?%s", 'https://api.eyecon-app.com/app/pic', http_build_query($data));

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 1);

		$result = curl_exec($ch);

		$graph_url = "";
		if(curl_getinfo($ch, CURLINFO_REDIRECT_URL)){
			$graph_url = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
		}

		$response = [
			'status_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
			'graph_url' => $graph_url
		];

		curl_close($ch);

		// return $graph_url;

		return (object) $response;
	}

	public function get_eyecon_app_name($phone_code, $phone_number){
		$phone_number = str_replace("+", "", $phone_code).$phone_number;

		$headers = array(
			"e-auth-v: ".$this->e_auth_v,
			"e-auth: ".$this->e_auth,
			"e-auth-c: ".$this->e_auth_c,
			"e-auth-k: ".$this->e_auth_k,
			// "User-Agent: ".$this->user_agent,
			"User-Agent: ".$_SERVER['HTTP_USER_AGENT'],
			"Connection: Keep-Alive",
			"Accept-Encoding: gzip",
			"accept: application/json",
			"accept-charset: UTF-8",
			"content-type: application/x-www-form-urlencoded; charset=utf-8"
		);

		$data = [
			'cli' => $phone_number,
			'lang' => 'en',
			'is_callerid' => true,
			'is_ic' => true,
			'cv' => 'vc_416_vn_3.0.416_a',
			'requestApi' => "okHttp",
			'source' => 'Other'
		];

		$url = sprintf("%s?%s", 'https://api.eyecon-app.com/app/getnames.jsp', http_build_query($data));

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 1);

		$result = curl_exec($ch);

		$name = "";
		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200){
			$result_arr = json_decode($result, true);
			$name = isset($result_arr[0])?$result_arr[0]['name']:'';
		}

		return $name;

		curl_close($ch);
	}

	public function get_username($id){
		$url = 'https://www.facebook.com/'.$id;

		$headers = array(
			// "User-Agent: ".$this->user_agent,
			"User-Agent: ".$_SERVER['HTTP_USER_AGENT'],
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
		curl_setopt($ch, CURLOPT_HEADER, 1);

		$result = curl_exec($ch);

		$username = "";
		if(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL)){
			$redirect_url = urldecode(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
			$redirect_url_arr = explode('/', $redirect_url);
			$username = explode('?', $redirect_url_arr[3])[0];
			if($username == 'login.php'){
				$redirect_url_arr = explode('/', explode('?', $redirect_url)[1]);
				$username = explode('&', $redirect_url_arr[3])[0];
			}
		}

		curl_close($ch);

		return $username;
	}

	public function profile_pic_url($graph_url){
		$url = $graph_url;

		$headers = array(
			// "User-Agent: ".$this->user_agent,
			"User-Agent: ".$_SERVER['HTTP_USER_AGENT'],
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
		curl_setopt($ch, CURLOPT_HEADER, 1);

		$result = curl_exec($ch);

		$profile_pic_url = "";
		if(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL)){
			$profile_pic_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		}

		curl_close($ch);

		return $profile_pic_url;
	}

	public function get_fb_details($phone_code, $phone_number){

		$eyecon_name = "";
		$user_id = "";
		$username = "";
		$profile_url = "";
		$profile_pic_url = "";

		/* Get eyecon app name */
		$eyecon_name = $this->get_eyecon_app_name($phone_code, $phone_number);

		/* Get facebook graph url */
		$get_url_response = $this->get_url($phone_code, $phone_number);
		$graph_url = $get_url_response->graph_url;

		if($graph_url != ''){
			$pieces = parse_url($graph_url);
			$domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];

			if($domain == "graph.facebook.com"){
				$graph_url_arr = explode('/', $graph_url);
				$user_id = $graph_url_arr[3];

				/* Get facebook username */
				$username = $this->get_username($user_id);
				if($username != ''){
					$profile_url = 'https://www.facebook.com/'.$username;
				}else{
					$profile_url = 'https://www.facebook.com/'.$user_id;
				}

				/* Get facebook profile pic url */
				$profile_pic_url = $this->profile_pic_url($graph_url);
				$profile_pic_url = ($profile_pic_url != '') ? $profile_pic_url : $graph_url;
			}else{
				$profile_pic_url = $graph_url;
			}
		}

		if($get_url_response->status_code == 401){
			$status_code = 	$get_url_response->status_code;
		}elseif($user_id == '' && $username == '' && $profile_url == '' && $profile_pic_url == ''){
			$status_code = 	404;
		}else{
			$status_code = 	200;
		}

		// $status_code = ($user_id == '' && $username == '' && $profile_url == '' && $profile_pic_url == '') ? 404 : 200;

		$response = json_encode([
			'status_code' => $status_code,
			'response' => [
				'eyecon_name' => $eyecon_name,
				'user_id' => $user_id,
				'username' => $username,
				'profile_url' => $profile_url,
				'profile_pic_url' => $profile_pic_url
			]
		]);

		return json_decode($response);
	}
}