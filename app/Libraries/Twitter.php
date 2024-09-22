<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class Twitter
{
	public function find_user_by_username($username){

		// $token = 'Bearer AAAAAAAAAAAAAAAAAAAAABphiQEAAAAAbV2d10THP1JML%2F4DT9SZmsUiiMY%3DnzJIoVlEkTQniRUac4z6GUXeoA5lMFYSLte3S2PfnhMdI57Lh7';

		$twitter_credentials = app('api_services')['twitter'];
		$authorization = $twitter_credentials['authorization'] ?? '';

		$headers = array(
			'Content-Type: application/json',
			sprintf('Authorization: %s', $authorization)
		);

		$ch = curl_init('https://api.twitter.com/2/users/by/username/'.$username.'?user.fields=created_at,description,entities,id,location,name,pinned_tweet_id,profile_image_url,protected,public_metrics,url,username,verified,withheld');

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