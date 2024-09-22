<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Events\Search;
use App\Events\BlockchainSearch as BlockchainSearchEvent;

use App\Models\SearchResult;
use App\Models\SearchHistory;
use App\Models\ApiService;
use App\Models\BlockchainSearch;
use App\Models\BlockchainSearchResult;
use App\Models\BlockchainSearchHistory;

use App\Libraries\HaveIBeenPwned;
use App\Libraries\Truecaller\Main as Truecaller;
use App\Libraries\Numverify;
use App\Libraries\Facebook;
use App\Libraries\Whatsapp;
use App\Libraries\Telegram\Main as Telegram;
use App\Libraries\Chainsight;
use App\Libraries\Blockcypher;
use App\Libraries\Getcontact;
use App\Models\UserKey;
use App\Models\User;
use App\Models\TelegramUser;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function __construct() {
        //
    }
    /**
     * Internal api request call
     * @param  string $method
     * @param  string $request_url
     * @param  array  $request_params
     * @return \Illuminate\Http\Response
     */
    public function internal_api_call($method = "GET", $request_url = "", $request_params = [])
    {
        $api_request = Request::create($request_url, $method, $request_params);
        return $api_response = \Route::dispatch($api_request);
    }

    /**
     * Manage user daily search limit per day.
     *
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function daily_search_limit($request)
    {
        $search_limt_per_day = 5;

        $today_search_count = \App\Models\SearchHistory::whereNull('user_id')->where('ip_address', $request->ip())->whereDate('created_at', date('Y-m-d'))->count();

        $remaining_limit = $search_limt_per_day - $today_search_count;
        $exceeded = ($remaining_limit > 0) ? false : true;

        if($exceeded){
            return (object) ['exceeded' => $exceeded, 'message' => 'Your daily search limit exceeded!'];
        }else{
            return (object) ['exceeded' => $exceeded];
        }
    }

    /**
     * Search by phone
     * @param  string $request
     * @return \Illuminate\Http\Response
     */
    public function search_by_phone($request){

        if(\Auth::user()){

        $user = \Auth::user();
        }else{

        $headers = $request->header('x-api-key');

        $user_keys = UserKey::with('users')->where(['key'=>$headers,'is_active'=>'Y'])->first();

        $user = $user_keys->users;

        }

        $country_code = $request->get('country_code');
        $phone_number = $request->get('phone_number');
  
        /* Get country detail */
        $country = \App\Models\Country::where('code', $country_code)->first();

        $search_result_exists = SearchResult::where('search_key', 'phone')
        ->where('country_code', $country->code)
        ->where('search_value', $phone_number)
        ->first();

        if($search_result_exists){
            $search_history_exists = SearchHistory::where('search_result_id', $search_result_exists->id)
            ->where('user_id', $user->id)
            ->first();

            if((!$search_history_exists)){

                /* Update more than 7th days search result */
                $expired_at = $search_result_exists->updated_at->addDays(7);
                if($expired_at < now()){
                    $phone_number_details = $this->get_details_by_phone($country_code, $phone_number);
                    $phone_number_details = json_decode($phone_number_details);

                    if($phone_number_details->status_code == 200){
                        $search_result_exists->result = json_encode((array)$phone_number_details->data);
                        $search_result_exists->updated_by = $user->id;
                        $search_result_exists->save();

                        /* deduct credit for search */
                        $this->deduct_credit($user->id);
                    }
                }
            }

            /* Save search history */
            event(new Search([
                'user_id' => $user->id,
                'request_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'search_result_id' => $search_result_exists->id
            ]));

            $response = json_encode([
                'status_code' => (int) $search_result_exists->status_code,
                'data' => json_decode($search_result_exists->result, true)
            ]);
        }else{

            $phone_number_details = $this->get_details_by_phone($country_code, $phone_number);
            $phone_number_details = json_decode($phone_number_details);

            $message = 'Record get successfully.';
            if($phone_number_details->status_code == 404){
                $message = 'Record not found.';
            }elseif($phone_number_details->status_code == 401){
                $message = 'Unauthorized services.';
            }

            $search_result = new SearchResult;
            $search_result->search_key = 'phone';
            $search_result->country_code = $country->code;
            $search_result->search_value = $phone_number;
            $search_result->status_code = $phone_number_details->status_code;
            $search_result->message = $message;
            $search_result->result = json_encode((array) $phone_number_details->data);
            $search_result->save();

            /* Save search history */
            event(new Search([
                'user_id' => $user->id,
                'request_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'search_result_id' => $search_result->id
            ]));

            /* deduct credit for search */
            if($phone_number_details->status_code == 200){
                $this->deduct_credit(auth()->user()->id);
            }

            $response = json_encode((array) $phone_number_details);

        }

        return $response;
    }

    /**
     * Get detail by phone
     * @param  string $country_code
     * @param  string $phone_number
     * @return \Illuminate\Http\Response
     */
    public function get_details_by_phone($country_code, $phone_number){
         
    $names = $images = $emails = $addresses = $carrier_details = [];
    
       if($country_code == 'PK'){
       
       $contact_info = new Getcontact();
       $check_info = $contact_info->details($phone_number);
       
         }

    if(($country_code == 'PK') && !empty($check_info)){

       $response = [
        'status_code' => 200,
        'data' => [
            'names' => [$check_info[0]->Name],
            'addresses' => [$check_info[0]->Address],
            'cnic' => [$check_info[0]->CNIC],
            'mobile' => [$check_info[0]->Mobile],
        ]
    ];

    $response = json_encode($response);
    return $response;

    }else{

        $obj_hibp = new HaveIBeenPwned();
        $obj_truecaller = new Truecaller();
        $obj_numverify = new Numverify();
        $obj_facebook = new Facebook();
        $obj_whatsapp = new Whatsapp();
        $obj_telegram = new Telegram();

        $truecaller = null;
        $facebook = null;
        $numverify = null;
        $whatsapp = null;
        $telegram = null;


        /* Get country detail */
        $country = \App\Models\Country::where('code', $country_code)->first();
        
        /* Get truecaller details */
        $truecaller_details = $obj_truecaller->truecaller_details($country->code, $phone_number);
        $response = json_decode($truecaller_details['response']);

        if($truecaller_details['status_code'] != 200){
            $truecaller = null;
        }else if(count($response->data) == 0){
            $truecaller = null;
        }else{
            $truecaller = $response->data[0];
        }
    
        //Update api status
        $this->update_api_service_status('truecaller', $truecaller_details['status_code']);
        
        if($truecaller != null){
            if(isset($truecaller->image)){
                $images['truecaller'] = $truecaller->image;
            }

            if(isset($truecaller->name)){
                $names['truecaller'] = $truecaller->name;
            }

            foreach($truecaller->internetAddresses as $internetAddresses){
                $breached_account = $obj_hibp->checkBreachedAccount($internetAddresses->id);

                if($breached_account->breached){
                    $emails['truecaller'] = ['email' => $internetAddresses->id, 'breached' => 'Pwned in '.count(json_decode($breached_account->records, true)).' data breaches.'];
                }else{
                    $emails['truecaller'] = ['email' => $internetAddresses->id, 'breached' => ''];
                }

                //Update api status
                $this->update_api_service_status('have-i-been-pwned', $breached_account->status_code);
            }

            foreach($truecaller->addresses as $address){
                $city = $address->city ?? 'Not Found';
                $countryCode = $address->countryCode;

                if(isset($address->city) &&  $address->city != '' && isset($address->countryCode) && $address->countryCode != ''){
                    $addresses['truecaller'] = $city." , ".$countryCode;
                }
            }

            $phone_detail = $truecaller->phones[0];
            $carrier_details['truecaller'] = [
                'carrier' => $phone_detail->carrier,
                'dialing_code' => $phone_detail->dialingCode,
                'international_format' => $phone_detail->e164Format,
                'phone_type' => $phone_detail->numberType,
                'country_code' => $phone_detail->countryCode,
            ];
        }

        /* Get numverify details */
        $numverify_details = $obj_numverify->numverify_details($country->phone_code, $phone_number);
        if($numverify_details->status_code != 200){
            $numverify = null;
        }elseif(isset($numverify_details->response->message) && $numverify_details->response->message != ''){
            $numverify = null;
        }else{
            $numverify = $numverify_details->response;
        }

        //Update api status
        $this->update_api_service_status('numverify', $numverify_details->status_code);

        if($numverify != null){
            if($numverify->location != '' && $numverify->country_name != ''){
                $addresses['numverify'] = $numverify->location." , ".$numverify->country_name;
            }

            $carrier_details['numverify'] = [
                'carrier' => $numverify->carrier,
                'dialing_code' => $numverify->country_prefix,
                'international_format' => $numverify->international_format,
                'phone_type' => $numverify->line_type,
                'country_code' => $numverify->country_code,
            ];
        }

        /* Get facebook details */
        $fb_details = $obj_facebook->get_fb_details($country->phone_code, $phone_number);
        if($fb_details->status_code == 200){
            $facebook = $fb_details->response;
        }

        //Update api status
        $this->update_api_service_status('facebook', $fb_details->status_code);

        if($facebook != null){
            if($facebook->eyecon_name != ''){
                $names['eyecon'] = $facebook->eyecon_name;
            }
            if($facebook->profile_pic_url != ''){
                $images['eyecon'] = $facebook->profile_pic_url;
            }
        }

        /* Get whatsapp details */
        $wa_details = $obj_whatsapp->get_details($country->phone_code, $phone_number);
        if($wa_details->status_code == 200){
            $whatsapp = $wa_details->response;
        }

        //Update api status
        $this->update_api_service_status('whatsapp', $wa_details->status_code);

        if($whatsapp != null){
            if($whatsapp->avatar_url != ''){
                $images['green-api'] = $whatsapp->avatar_url;
            }
            if($whatsapp->contact_info != ''){
                if($whatsapp->contact_info->name){
                    $names['green-api'] = $whatsapp->contact_info->name;
                }
                if($whatsapp->contact_info->email){
                    $emails['green-api'] = $whatsapp->contact_info->email;
                }
            }
        }

        /* Get telegram details */
        $telegram_details = $obj_telegram->get_details($country->phone_code, $phone_number);
        if($telegram_details->status_code == 200){
            $telegram = $telegram_details->response;
        }

        //Update api status
        $this->update_api_service_status('telegram', $telegram_details->status_code);


        if($truecaller_details['status_code'] == 401 && $numverify_details->status_code == 401 && $fb_details->status_code == 401 && $wa_details->status_code == 401 && $telegram_details->status_code == 401){
            $response = [
                'status_code' => 401,
                'data' => null
            ];
        }elseif($truecaller == null && $numverify == null && $facebook == null && $whatsapp == null && $telegram == null){
            $response = [
                'status_code' => 404,
                'data' => null
            ];
        }else{
            $response = [
                'status_code' => 200,
                'data' => [
                    'names' => $names,
                    'images' => $images,
                    'emails' => $emails,
                    'addresses' => $addresses,
                    'carrier_details' => $carrier_details,
                    'truecaller' => $truecaller,
                    'numverify' => $numverify,
                    'facebook' => $facebook,
                    'whatsapp' => $whatsapp,
                    'telegram' => $telegram
                ]
            ];
        }
        
        $response = json_encode($response);
        return $response;
    }
    }

    /**
     * Search by email
     * @param  string $email
     * @return \Illuminate\Http\Response
     */
    public function search_by_email($email)
    {   
        exec("holehe ".$email." 2>&1", $output, $status);
        array_shift($output);
        $connected_accounts = $output;
        
        return json_encode($connected_accounts);
    }

    /**
     * Search blockchain by keyword
     * @param  string $request
     * @return \Illuminate\Http\Response
     */
    public function search_blockchain_by_keyword($request,$userinfo=null,$address=null,$userType=null){
       
        if(!is_null($userinfo) || ($userinfo) != '' ){
        
        if(!empty($address) && ($userType == 'tg_user')){
          
          $user_info = TelegramUser::where('telegram_id',$userinfo)->first();
          $user = $user_info;

          }else{
            $user = $userinfo;
          }

        }else{

            $user = \Auth::user();
        }

        if(empty($request->keyword)){

           $keyword = $address;

       }else{

           $keyword = $request->get('keyword');

       }

        $blockchain_search_exists = BlockchainSearch::where('keyword', $keyword)
        ->first();

        if($blockchain_search_exists){

            if($userType == 'tg_user'){

            $blockchain_search_history_exists = BlockchainSearchHistory::where('search_id', $blockchain_search_exists->id)
            ->where('user_id', $user->id)
            ->where('user_type','tg_user')
            ->first();

            }else{

            $blockchain_search_history_exists = BlockchainSearchHistory::where('search_id', $blockchain_search_exists->id)
            ->where('user_id', $user->id)
            ->first();

            }


            if(!$blockchain_search_history_exists || $blockchain_search_exists->status_code != 200){

                /* Update more than 1 day search result */
                $expired_at = $blockchain_search_exists->updated_at->addDays(1);
                if($expired_at < now() || $blockchain_search_exists->status_code != 200){
                    $blockchain_details = $this->get_blockchain_details($keyword);
                    $blockchain_details = json_decode($blockchain_details);

                    if($blockchain_details->status_code == 200){
                        $blockchain_search_exists->result = json_encode((array)$blockchain_details->result);
                        $blockchain_search_exists->updated_by = $user->id;
                        $blockchain_search_exists->status_code = 200;
                        $blockchain_search_exists->save();

                        /* Store search results */
                        BlockchainSearchResult::where('search_id', $blockchain_search_exists->id)->delete();

                        $last_unique_id = 1000;
                        $last_result_record = BlockchainSearchResult::orderBy('id', 'desc')->first();
                        if($last_result_record){
                            $last_unique_id = $last_result_record->unique_id;
                        }

                        $blockchain_search_result_arr = [];
                        foreach($blockchain_details->result->data as $value){
                            $last_unique_id++;
                            $blockchain_search_result_arr[] = [
                                'unique_id' => $last_unique_id,
                                'search_id' => $blockchain_search_exists->id,
                                'type' => $value->type,
                                'chain' => (is_null($value->chain)) ? null : json_encode($value->chain),
                                'address' => $value->address,
                                'url' => $value->url,
                                'domain' => $value->domain,
                                'ip' => $value->ip,
                                'name' => $value->name,
                                'symbol' => $value->symbol,
                                'anti_fraud' => (is_null($value->antiFraud)) ? null : json_encode($value->antiFraud),
                                'labels' => (is_null($value->labels)) ? null : json_encode($value->labels),
                                'created_at' => now()
                            ];
                        }

                        BlockchainSearchResult::insert($blockchain_search_result_arr);

                        /* get and store data from blockcypher */
                        $this->get_blockcypher_details($keyword, $blockchain_search_exists->id);

                        /* deduct credit for search */
                        /* $this->deduct_credit($user->id); */
                    }
                }
            }

            /* Save search history */
            
            if(!empty($request)){
             
             $user_ip = $request->ip();
             $user_agent = $request->userAgent();

            }else{

             $user_ip = '';
             $user_agent = '';

            }

            event(new BlockchainSearchEvent([
                'user_id' => $user->id,
                'user_type' => $userType,
                'request_ip' => $user_ip,
                'user_agent' => $user_agent,
                'search_id' => $blockchain_search_exists->id
            ]));

            $response = json_encode([
                'status_code' => (int) $blockchain_search_exists->status_code,
                'data' => json_decode($blockchain_search_exists->result, true)
            ]);
        }else{
            $blockchain_details = $this->get_blockchain_details($keyword);
            $blockchain_details = json_decode($blockchain_details);
            $message = 'Record get successfully.';
            if($blockchain_details->status_code == 404){
                $message = 'Record not found.';
            }elseif($blockchain_details->status_code == 401){
                $message = 'Unauthorized services.';
            }

            $blockchain_search = new BlockchainSearch;
            $blockchain_search->keyword = $keyword;
            $blockchain_search->status_code = $blockchain_details->status_code;
            $blockchain_search->message = $message;
            $blockchain_search->result = json_encode((array) $blockchain_details->result);

            if($blockchain_search->save() && $blockchain_details->status_code == 200){

                /* Store search results */
                $last_unique_id = 1000;
                $last_result_record = BlockchainSearchResult::orderBy('id', 'desc')->first();
                if($last_result_record){
                    $last_unique_id = $last_result_record->unique_id;
                }

                $blockchain_search_result_arr = [];
                foreach($blockchain_details->result->data as $value){
                    $last_unique_id++;
                    $blockchain_search_result_arr[] = [
                        'unique_id' => $last_unique_id,
                        'search_id' => $blockchain_search->id,
                        'type' => $value->type,
                        'chain' => (is_null($value->chain)) ? null : json_encode($value->chain),
                        'address' => $value->address,
                        'url' => $value->url,
                        'domain' => $value->domain,
                        'ip' => $value->ip,
                        'name' => $value->name,
                        'symbol' => $value->symbol,
                        'anti_fraud' => (is_null($value->antiFraud)) ? null : json_encode($value->antiFraud),
                        'labels' => (is_null($value->labels)) ? null : json_encode($value->labels),
                        'created_at' => now()
                    ];
                }

                BlockchainSearchResult::insert($blockchain_search_result_arr);

                /* get and store data from blockcypher */
                $this->get_blockcypher_details($keyword, $blockchain_search->id);
            }

            if(!empty($request)){
             
             $user_ip = $request->ip();
             $user_agent = $request->userAgent();

            }else{

             $user_ip = '';
             $user_agent = '';

            }

            /* Save search history */
            event(new BlockchainSearchEvent([
                'user_id' => $user->id,
                'user_type' => $userType,
                'request_ip' => $user_ip,
                'user_agent' => $user_agent,
                'search_id' => $blockchain_search->id
            ]));

            /* deduct credit for search */
            /* if($blockchain_details->status_code == 200){
                $this->deduct_credit(auth()->user()->id);
            } */
            $response = json_encode((array) $blockchain_details);
        }

        return $response;
    }

    /**
     * Get blockchain details by keyword (Domain name | Address | Url) 
     * @param  string $keyword
     * @return \Illuminate\Http\Response
     */
    public function get_blockchain_details($keyword){

        $obj_chainsight = new Chainsight();

        $chainsight = null;

        /* Get chainsight details */
        $chainsight_details = $obj_chainsight->details($keyword);
        if($chainsight_details->status_code != 200){
            $chainsight = null;
        }elseif(isset($chainsight_details->response->message) && $chainsight_details->response->message != ''){
            $chainsight = null;
        }else{
            $chainsight = $chainsight_details->response;
        }

        //Update api status
        $this->update_api_service_status('chainsight', $chainsight_details->status_code);


        return json_encode([
            'status_code' => $chainsight_details->status_code,
            'result' => $chainsight
        ]);
    }


    function get_blockcypher_details($address, $search_id){
        $blockcypher = null;
        $obj_blockcypher = new Blockcypher();

        $blockcypher_details = $obj_blockcypher->details($address);
        if($blockcypher_details->status_code != 200){
            $blockcypher = null;
        }elseif(isset($blockcypher_details->response->message) && $blockcypher_details->response->message != ''){
            $blockcypher = null;
        }else{
            $blockcypher = $blockcypher_details->response;
        }

        if($blockcypher != null){
            $bc_address_detail = \App\Models\BlockchainAddressDetail::updateOrCreate(
                ['search_id' => $search_id],
                [
                    'currency' => $blockcypher->currency,
                    'address' => $blockcypher->address,
                    'total_received' => $blockcypher->total_received,
                    'total_sent' => $blockcypher->total_sent,
                    'balance' => $blockcypher->balance,
                    'total_txn' => $blockcypher->total_txn,
                    'incoming_txn' => $blockcypher->incoming_txn,
                    'outgoing_txn' => $blockcypher->outgoing_txn,
                    'first_seen_at' => $blockcypher->first_seen_at,
                    'last_seen_at' => $blockcypher->last_seen_at,
                ]
            );

            if($bc_address_detail){

                \App\Models\BlockchainAddressTxn::where('address_detail_id', $bc_address_detail->id)->delete();
                \App\Models\BlockchainAddressTxnInout::where('address_detail_id', $bc_address_detail->id)->delete();

                $transactions = [];
                foreach($blockcypher->transactions as $txn){
                    $transactions[] = [
                        'address_detail_id' => $bc_address_detail->id,
                        'txn_id' => $txn->txn_id,
                        'block_hash' => $txn->block_hash,
                        'block_height' => $txn->block_height,
                        'amount' => $txn->amount,
                        'fees' => $txn->fees,
                        'confirmed_at' => $txn->confirmed_at,
                        'inputs' => json_encode((array) $txn->inputs),
                        'outputs' => json_encode((array) $txn->outputs)
                    ];
                }

                $inouts = [];
                foreach($blockcypher->inouts as $inout){
                    $inouts[] = array_merge([
                        'address_detail_id' => $bc_address_detail->id,
                    ], (array) $inout);
                }

                \App\Models\BlockchainAddressTxn::insert($transactions);
                \App\Models\BlockchainAddressTxnInout::insert($inouts);
            }
        }

        //Update api status
        $this->update_api_service_status('blockcypher', $blockcypher_details->status_code);
    }

    /**
     * deduct credit for user.
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function deduct_credit($user_id)
    {
        $credit_per_search = 1;

        $user_credit = \App\Models\UserCredit::where('user_id', $user_id)
        ->where('available_credits', '>', 0)
        ->where('expired_at', '>', now())
        ->orderBy('created_at')
        ->first();

        if($user_credit){
            $user_credit->available_credits = $user_credit->available_credits - $credit_per_search;
            $user_credit->save();
        }
    }

    /**
     * Update api service status.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_api_service_status($api_service_slug, $status_code)
    {
        if(!in_array($status_code, [200, 404])){
            $error_code = $status_code;
            $error_message = get_http_code_message($status_code);
        }else{
            $error_code = null;
            $error_message = null;
        }

        ApiService::where('slug', $api_service_slug)->update([
            'error_code' => $error_code,
            'error_message' => $error_message
        ]);
    }

    /**
     * Get country data.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_countries()
    {
        $countries = \App\Models\Country::orderBy('name')->get();
        
        return $countries->pluck('phone_code', 'code');
    }


    public function check_user_subscription(){

      $available_plan = available_plan();

      if($available_plan == 'No Sub'){
        
      $record = array(
        'route' => 'account.profile.subscription',
        'message' => 'Oop`s you can not enjoy this feature without any subscription',
        'status' => 'danger',
        );
      
      return $record;

    }elseif($available_plan == 'No Active Sub'){

      $record = array(
        'route' => 'account.profile.subscription',
        'message' => 'Oop`s  your current subscription deactivated by admin',
        'status' => 'danger',
        );
        
        return $record;

    }elseif($available_plan == 'Expired Sub'){

       $record = array(
        'route' => 'account.profile.subscription',
        'message' => 'Oop`s your current subscription has expired',
        'status' => 'danger',
        );
         return $record;
    }else{
 
    }
}

   public function check_expired_subscription(){

   }


}
