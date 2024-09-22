<?php

if (! function_exists('admin_url')) {
	function admin_url()
	{
		$admin_url = 'backend';

		try{
			$general_settings = \App\Models\Setting::where('key', 'admin')->first();
			if($general_settings){
				$admin_url = json_decode($general_settings->value)->admin_url;
			}
			return $admin_url;
		}catch(\Exception $e){
			return $admin_url;
		}
	}
}

if (! function_exists('crypto_analysis_url')) {
	function crypto_analysis_url()
	{
	   $crypto_url = 'crypto-analysis';

		try{
			$general_settings = \App\Models\Setting::where('key', 'crypto')->first();
			if($general_settings){
				$crypto_url = json_decode($general_settings->value)->crypto_url;
			}
			return $crypto_url;
		}catch(\Exception $e){
			return $crypto_url;
		}
	}
}

if (! function_exists('getNormalImage')) {
function getNormalImage($document_path,$img_name)
{
	if($img_name != '' && \Storage::exists($document_path.'/'.$img_name)){

		$image = asset('storage/'.$document_path.'/'.$img_name);
        
		return $image;
	}else{
		return asset('assets/frontend/images/spyderlab_featured_image.png');
	}
}
}

if (! function_exists('settings')) {
	function settings($key)
	{
		$setting_arr = [];

		try{
			$setting = \App\Models\Setting::where('key', $key)->first();
			if($setting){
				$setting_arr = json_decode($setting->value);
			}
			return $setting_arr;
		}catch(\Exception $e){
			return $setting_arr;
		}
	}
}

if (! function_exists('is_kyc_mandatory')) {
	function is_kyc_mandatory()
	{
		try{
			$setting = \App\Models\Setting::take('1')->orderBy('id','desc')->first();
			if($setting){
				$setting_arr = json_decode($setting->value);
			}
			return $setting_arr;
		}catch(\Exception $e){
			return $setting_arr;
		}
	}
}

if (! function_exists('remove_exif')) {
	function remove_exif($path)
	{
		$oldpath = $path;
		$newpath = $path;
		
		$img = new Imagick($oldpath);
		$img->stripImage();
		$img->writeImage($newpath);
		$img->destroy();
	}
}

if (! function_exists('get_visitor_details')) {
	function get_visitor_details($ip){
		$visitor_details = [];
		$result = @json_decode(file_get_contents(
			"http://www.geoplugin.net/json.gp?ip=" . $ip));

		if($result && $result->geoplugin_status == 200){
			$visitor_details['city'] = $result->geoplugin_city;
			$visitor_details['state'] = $result->geoplugin_regionName;
			$visitor_details['country'] = $result->geoplugin_countryName;
		}

		return $visitor_details;
	}
}

if (! function_exists('super_admin')) {
	function super_admin(){
		$super_admin = \App\Models\User::where('is_admin', 'Y')->first();
		return $super_admin;
	}
}

if (! function_exists('available_credits')) {
	function available_credits($user_id = ''){
		
		if(auth()->user()){
		$user_id = auth()->user()->id;
		}else{
        $user_id = $user_id;
		}

		$available_credits = \App\Models\UserCredit::where('user_id', $user_id)->where('expired_at', '>', now())->sum('available_credits');
		return $available_credits;
	}
}

if (! function_exists('available_plan')){
	function available_plan(){
		$user_id = auth()->user()->id;
		
		 $chk_user_sub = \App\Models\CryptoPlanSubscription::where(['user_id'=>$user_id])->orderBy('id','desc')->first();

		if(!is_null($chk_user_sub)){

            $check_active_sub = \App\Models\CryptoPlanSubscription::where(['user_id'=>$user_id])->where('is_active','N')->where('expired_date', '>=', now())->orderBy('id','desc')->first();


			if(is_null($check_active_sub)){

				$available_plan = \App\Models\CryptoPlanSubscription::where('user_id', $user_id)->where('expired_date', '>=', now())->orderBy('id','desc')->where('is_active','Y')->first();

				if(!is_null($available_plan)){

					return 1;

				}else{

					return "Expired Sub";
				}
			}else{
				return "No Active Sub";
			}
		}else{
			return 'No Sub';
		}
	}
}

if (! function_exists('plan_expire_at')) {
	function plan_expire_at(){
		if(auth()->user()){
			$user_id = auth()->user()->id;
			$d1 = Carbon\Carbon::now()->addDays(7);
			$d2 = \App\Models\CryptoPlanSubscription::where('user_id', $user_id)->first();

			if(!is_null($d2)){
				if(strtotime($d1) > strtotime($d2->expired_date)){
					return 'Y';
				}else{
					return 1;
				}
			} 
		}
	}
}

if (! function_exists('get_date_diff')) {
function get_date_diff(){

	if(auth()->user()){

$user_id = auth()->user()->id;

$info = \App\Models\CryptoPlanSubscription::where('user_id', $user_id)->first();

$firstDate = Carbon\Carbon::now();
$secondDate = $info->expired_date;

$datetime1 = new DateTime($firstDate);
$datetime2 = new DateTime($secondDate);

$interval = $datetime1->diff($datetime2);
$days = $interval->format('%a');
if($days > 1){

return $days ." days";

}elseif($days > 0){

return $days ." day";

}
}
}
}

if (! function_exists('plan_is_expire')) {
	function plan_is_expire(){
		if(auth()->user()){
			$user_id = auth()->user()->id;
			$d1 = Carbon\Carbon::now();
			$d2 = \App\Models\CryptoPlanSubscription::where('user_id', $user_id)->first();

			if(!is_null($d2)){
				if(strtotime($d1) > strtotime($d2->expired_date)){
					return 'Y';
				}else{
					return "N";
				}
			}
		}
	}
}


if (! function_exists('plan_is_expire_backend')) {
	function plan_is_expire_backend($id){
		if($id){
			$d1 = Carbon\Carbon::now();
			$d2 = \App\Models\CryptoPlanSubscription::where('id', $id)->first();

			if(!is_null($d2)){
				if(strtotime($d1) > strtotime($d2->expired_date)){
					return 'Y';
				}else{
					return "N";
				}
			}
		}
	}
}


if (!function_exists('get_http_code_message')) {
	function get_http_code_message($code) {

		switch ($code) {
			case 100: $text = 'Continue'; break;
			case 101: $text = 'Switching Protocols'; break;
			case 200: $text = 'OK'; break;
			case 201: $text = 'Created'; break;
			case 202: $text = 'Accepted'; break;
			case 203: $text = 'Non-Authoritative Information'; break;
			case 204: $text = 'No Content'; break;
			case 205: $text = 'Reset Content'; break;
			case 206: $text = 'Partial Content'; break;
			case 300: $text = 'Multiple Choices'; break;
			case 301: $text = 'Moved Permanently'; break;
			case 302: $text = 'Moved Temporarily'; break;
			case 303: $text = 'See Other'; break;
			case 304: $text = 'Not Modified'; break;
			case 305: $text = 'Use Proxy'; break;
			case 400: $text = 'Bad Request'; break;
			case 401: $text = 'Unauthorized'; break;
			case 402: $text = 'Payment Required'; break;
			case 403: $text = 'Forbidden'; break;
			case 404: $text = 'Not Found'; break;
			case 405: $text = 'Method Not Allowed'; break;
			case 406: $text = 'Not Acceptable'; break;
			case 407: $text = 'Proxy Authentication Required'; break;
			case 408: $text = 'Request Time-out'; break;
			case 409: $text = 'Conflict'; break;
			case 410: $text = 'Gone'; break;
			case 411: $text = 'Length Required'; break;
			case 412: $text = 'Precondition Failed'; break;
			case 413: $text = 'Request Entity Too Large'; break;
			case 414: $text = 'Request-URI Too Large'; break;
			case 415: $text = 'Unsupported Media Type'; break;
			case 429: $text = 'Too Many Requests'; break;
			case 500: $text = 'Internal Server Error'; break;
			case 501: $text = 'Not Implemented'; break;
			case 502: $text = 'Bad Gateway'; break;
			case 503: $text = 'Service Unavailable'; break;
			case 504: $text = 'Gateway Time-out'; break;
			case 505: $text = 'HTTP Version not supported'; break;
			default:
			$text = '';
			break;
		}

		return $text;
	}
}

if (!function_exists('get_currency_from_address')) {
	function get_currency_from_address($address) {
		$eth_pattern = "/^(0x)?(?i:[0-9a-f]){40}$/";
		if(preg_match($eth_pattern, $address)){
			$currency = 'eth';
		}else{
			$currency = 'btc';
		}

		return $currency;
	}
}

if (!function_exists('convertCurrency')) {
	function convertCurrency($from_currency="INR",$to_currency="USD",$amount=1){

     //    $req_url = 'https://api.exchangerate.host/latest?base='.$from_currency.'&amount='.$amount.'&symbols='.$to_currency;
     //    $response_json = file_get_contents($req_url);

     //    $hasConversion = false;
     //    $converted_amount = 0;
     //    if(false !== $response_json) {
     //        try {
     //            $response = json_decode($response_json);

     //            if($response->success === true) {

     //             // Read conversion rate
     //             $converted_amount = round($response->rates->$to_currency,2);

     //             $hasConversion = true;
     //         }

     //     } catch(Exception $e) {
     //        // Handle JSON parse error...

     //     }
     // }
     // return $converted_amount;
	return $amount;
	}
}

if (! function_exists('organization_jsonld')) {
	function organization_jsonld()
	{
		$metadataJson = [
			'@context' => 'https://schema.org',
			'@type' => 'Organization',
			'name' => 'https://www.spyderlab.org',
			'alternateName' => 'https://www.spyderlab.org',
			'url' => route('home'),
			'logo' => asset('assets/frontend/images/logo.png'),
			'contactPoint' => [
				'@type' => 'ContactPoint',
				'email' => 'info@spyderlab.org',
				'contactType' => 'email',
				'areaServed' => [
					"India",
					"United States",
					"Canada",
					"United Kingdom",
					"Australia",
					"New Zealand",
					"Germany",
					"Saudi Arabia",
					"United Arab Emirates",
					"Japan",
					"Russia",
					"Ukraine",
					"France",
					"Germany",
					"Italy",
					"Portugal",
					"Spain",
					"Czech Republic",
					"Poland",
					"Turkey",
					"China",
					"South Korea",
					"Brazil",
					"Argentina",
					"Netherlands",
					"Indonesia",
					"Philippines"
				],
				'availableLanguage' => [
					"English",
					"Russian",
					"French",
					"Japanese",
					"German",
					"Spanish",
					"Korean"
				],
				'sameAs' => [
					// "https://twitter.com/secureshift_io",
					// "https://www.reddit.com/r/secureshift/",
					// "https://t.me/secureshiftTg",
					// "https://www.facebook.com/secureshift"
				]
			]
		];

		return \sprintf(
			"<script type=\"application/ld+json\">%s</script>",
			stripslashes(json_encode($metadataJson, JSON_PRETTY_PRINT))
		);
	}
}

if (! function_exists('breadcrumbs_jsonld')) {
    function breadcrumbs_jsonld($items)
    {
        $metadataJson = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [],
        ];

        foreach ($items as $i => $item) {
        	$i++;
            $ldItem = [
                '@type' => 'ListItem',
                'position' => $i,
                'name' => $item['title'],
            ];

            if (!empty($item['url'])) {
                $ldItem['item'] = $item['url'];
            }

            $metadataJson['itemListElement'][] = $ldItem;
        }

        return \sprintf(
            "<script type=\"application/ld+json\">%s</script>",
            stripslashes(json_encode($metadataJson, JSON_PRETTY_PRINT))
        );
    }
}

function validateETHAddress($address) {
    if (!preg_match('/^(0x)?[0-9a-f]{40}$/i',$address)) {
        // check if it has the basic requirements of an address
        return false;
    } elseif (!preg_match('/^(0x)?[0-9a-f]{40}$/',$address) || preg_match('/^(0x)?[0-9A-F]{40}$/',$address)) {
        // If it's all small caps or all all caps, return true
        return true;
    } else {
        // Otherwise check each case
        return isChecksumAddress($address);
    }
}

function isChecksumAddress($address) {
    // Check each case
    $address = str_replace('0x','',$address);
    $addressHash = hash('sha3',strtolower($address));
    $addressArray=str_split($address);
    $addressHashArray=str_split($addressHash);

    for($i = 0; $i < 40; $i++ ) {
        // the nth letter should be uppercase if the nth digit of casemap is 1
        if ((intval($addressHashArray[$i], 16) > 7 && strtoupper($addressArray[$i]) !== $addressArray[$i]) || (intval($addressHashArray[$i], 16) <= 7 && strtolower($addressArray[$i]) !== $addressArray[$i])) {
            return false;
        }
    }
    return true;
}


function validateBTCAddress($address)
{

    $pattern = "/^((bc1[0-9A-Za-z]{32,64})|([13][a-km-zA-HJ-NP-Z1-9]{25,34}))$/";

	if(preg_match($pattern, $address)){
    return true;
	}else{
    return false;
	}

}

function validateLTCAddress($address){

     // the regular expression
     $pattern = '/^L[a-zA-Z0-9]{26,33}$/';

	if(preg_match($pattern, $address)){
    return true;
	}else{
    return false;
	}

}


