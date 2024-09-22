<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TelegramService;
use App\Models\BlockchainSearch;
use App\Models\BlockchainSearchResult;
use App\Libraries\Telegram\TelegramApp;
use App\Models\TelegramUser;
use App\Models\TelegramPackage;
use App\Models\TelegramSubscription;
use App\Models\TelegramTmpChat;
use App\Models\TelegramTransaction;
use App\Libraries\PaymentGateways\CoinPayment;

class TelegramPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        parent::__construct();
        $this->coin_payment = new CoinPayment();
    }


    public function index()
    {
      echo"Hi.......";
    }

     public function getTelegramWebHookResponse(Request $request){

       \Log::info($request->all());

        // $updateId = 0;
         // $telegramService = app(TelegramService::class);
        //$updates = $telegramService->getUpdated($updateId);
        // $updates = $telegramService->getWebhookUpdate();
    
        $updates_value = $request->all();
        $telegramService = app(TelegramService::class);
        $telegram = new TelegramApp();

        $text = '';

        $package = TelegramPackage::select('no_of_request','price')->get()->toArray();
        if(count($package) > 0){
            
            $package_array_r1 = [];
            $package_array_r2 = [];

            foreach(collect($package)->toArray() as $key=>$value){
                
                if($key < 2){
                    
                    $package_array_r1[] = $value['no_of_request'].' per '.'$'.$value['price'];
                    
                }else{
                    
                    $package_array_r2[] = $value['no_of_request'].' per '.'$'.$value['price'];
                }
            }

            $full_package = array($package_array_r1,$package_array_r2);
            $mearge_full_package = array_merge($package_array_r1,$package_array_r2);
        }else{
            $full_package = array();
            $mearge_full_package = array();
        }

        if(isset($updates_value['callback_query'])){

            if(in_array($updates_value['callback_query']['data'],array('btc','eth','ltct'))){

                $userInfo = TelegramUser::where('telegram_id',$updates_value['callback_query']['from']['id'])->first();

                $getUserLast_row = TelegramTmpChat::where('tm_user_id',$updates_value['callback_query']['from']['id'])->update(['currency'=>strtoupper($updates_value['callback_query']['data'])]);

                $tmp_record = TelegramTmpChat::where('tm_user_id',$userInfo->telegram_id)->orderBy('id','desc')->first();
                
                if(empty($tmp_record)){

                    $keyboard = [
                        ['Check', 'Top up'],
                        ['Investigation', 'Tracking']
                    ];

                    $text = "Failed to recognize the command. Please select the bellow buttons.";
                    $telegramService->sendMessage($updates_value['callback_query']['message']['chat']['id'],$text,$keyboard);

                }

                $currency1 = 'USD';
                $currency2 = strtoupper($updates_value['callback_query']['data']);
                //$currency2 = 'LTCT';

                $total_payable_amount = $tmp_record->amount;

                $response = $this->coin_payment->create_telegram_user_transaction($userInfo,'',$total_payable_amount, $currency1, $currency2);

                if($response['error'] == 'ok'){

                    $keyboard = array();
                //$text = $response['result']['address'];

                    TelegramTransaction::create([
                        'user_id' => $userInfo->id,
                        'package_id' => $tmp_record->package_id,
                        'sub_type' => $tmp_record->sub_type,
                        'no_of_request' => $tmp_record->no_of_request,
                        'payment_amount'=>$response['result']['amount'],
                        'payment_type'=>'crypto',
                        'payment_amount_in_usd'=>$total_payable_amount,
                        'coin_type'=> strtoupper($currency2),
                        'coin_address'=> $response['result']['address'],
                        'txn_status'=> 'pending',
                        'txn_id'=> $response['result']['txn_id'],
                        'checkout_url'=> $response['result']['checkout_url'],
                        'status_url'=> $response['result']['status_url'],
                        'qrcode_url'=> $response['result']['qrcode_url'],
                    ]);

                    $text_zero = '<b>Your package '.$tmp_record->no_of_request.' for '.'$'.$total_payable_amount.'</b>';

                    $text_one = 'Invoice for '.$response['result']['amount'].' '.strtoupper($currency2).' has been created.';

                    $text_one.='Please note that your payment will be processed by a third-party payment service provider and not by Safelement Limited. A third-party payment service provider may block the payment and request additional information. You agree that you shall share with us such additional information or documents to comply with a third-party payment service provider’s request. In case of non-cooperation from your side, we will not be able to complete the payment or return it to you if you decide to proceed with a refund.';

                    $text_one.='Top up will be proceeded correctly when the entire amount is paid by one transaction.
                    Consider the transaction fee.';

                    $text_one.'Checks are credited to the balance automatically, usually within 10-30 minutes after the transaction is confirmed in blockchain.';

                    $text_two = 'Pay the amount on below address. ';

                    $text_two.= '<b>'.$response['result']['address'].'</b>';

                    $text_three = $response['result']['qrcode_url'];

                    $telegramService->sendMessage($updates_value['callback_query']['message']['chat']['id'],$text_zero,$keyboard);

                    $telegramService->sendMessage($updates_value['callback_query']['message']['chat']['id'],$text_one,$keyboard);

                    $telegramService->sendMessage($updates_value['callback_query']['message']['chat']['id'],$text_two,$keyboard);

                    $telegramService->sendPhoto($updates_value['callback_query']['message']['chat']['id'],$text_three);

                    /* after complete the process remove the temporary chat user */
                    TelegramTmpChat::where('tm_user_id',$userInfo->telegram_id)->delete();         
                }else{

                    $keyboard = array();
                    $text = $response['error'];
                    $telegramService->sendMessage($updates_value['callback_query']['message']['chat']['id'],$text,$keyboard);

                }
            }
        }else{

            $check_tmp_package = TelegramTmpChat::where('tm_user_id',$updates_value['message']['chat']['id'])->orderBy('id','desc')->first();


            if(($updates_value['message']['text'] == '/start') || ($updates_value['message']['text'] == '/menu')){

                if($updates_value['message']['text'] == '/start'){

                    $text .='Welcome!

                    Hello 👋.

                    Want to check BTC/ETH coins before buying?

                    Just enter the address of a wallet or transaction and I will analyze all incoming/outgoing blockchain transactions and give you the assessment of potential risks.

                    To perform the checking, please top up your balance with BTC or other coins in the menu.';

                    /* register telegram user */
                    $telegram->registerUser($updates_value['message']['from']);

                    /* remove the temporary chat if it exist */
                    TelegramTmpChat::where('tm_user_id',$updates_value['message']['from']['id'])->delete();

                }else{
                    $text = 'please select the buttons.';
                }

                $keyboard = [
                    ['Check', 'Top up'],
                    ['Investigation', 'Tracking']
                ];

                $telegramService->sendMessage($updates_value['message']['chat']['id'],$text,$keyboard);




            }elseif(($updates_value['message']['text'] == 'Check')){

                $keyboard = [
                    ['BTC', 'ETH'],
                    ['LTC', 'DOGE'],
                    ['DASH'],
                ];

                $text = "please select your coin.";
                $telegramService->sendMessage($updates_value['message']['chat']['id'],$text,$keyboard);

            }elseif(in_array($updates_value['message']['text'],array('BTC','ETH','BNB','TON'))){

                $keyboard = array();
                $text = "please enter your ".$updates_value['message']['text']." address.";

                $telegramService->sendMessage($updates_value['message']['chat']['id'],$text,$keyboard);


            }elseif(validateETHAddress($updates_value['message']['text']) || validateBTCAddress($updates_value['message']['text'])){

                $keyboard = array();

                $response = $telegram->getAddressDetails($updates_value['message']['text'],$updates_value['message']['from']['id']);

                if($response['status_code']  == 401){

                    $keyboard = array();
                    $text = "Sorry we are unable to get information of this address, try another.";
                    $telegramService->sendMessage($updates_value['message']['chat']['id'],$text,$keyboard);

                }

                /* risk score */
                if($response['status_code']  == 200){

                    if($response['chainsight']->anti_fraud->credit == 1){

                        $risk_score = "Safe";

                    }elseif($response['chainsight']->anti_fraud->credit == 2){

                        $risk_score = "Low";

                    }elseif($response['chainsight']->anti_fraud->credit == 3){

                        $risk_score = "High";

                    }else{
                        $risk_score = "NaN";
                    }

                    $blockcypher = $response['blockcypher'];


                    /* currency */
                    $currency = strtoupper($blockcypher['address_details']->currency);

                    /*  balance */
                    if($blockcypher['address_details']->currency == 'btc'){

                        $balance = round($blockcypher['address_details']->balance/config('constants.blockcypher.amount.btc'), 4).' BTC';


                    }elseif($blockcypher['address_details']->currency == 'eth'){

                        $balance = round($blockcypher['address_details']->balance/config('constants.blockcypher.amount.eth'), 4).' ETH';

                    }

                    /*  first seen at */
                    $first_seen_at = !is_null($blockcypher['address_details']->first_seen_at) ? gmdate('M d, Y, h:i A', strtotime($blockcypher['address_details']->first_seen_at)).'(UCT)' : null;

                    /*  last seen at */
                    $last_seen_at = !is_null($blockcypher['address_details']->last_seen_at) ? gmdate('M d, Y, h:i A', strtotime($blockcypher['address_details']->last_seen_at)).'(UTC)' : '';

                    /* total receive */
                    $total_received = $blockcypher['address_details']->total_received;

                    if($blockcypher['address_details']->currency == 'btc'){

                        $total_received = round($blockcypher['address_details']->total_received/config('constants.blockcypher.amount.btc'), 4).' BTC';

                    }elseif($blockcypher['address_details']->currency == 'eth'){

                        $total_received = round($blockcypher['address_details']->total_received/config('constants.blockcypher.amount.eth'), 4).' ETH';

                    }

                    /* total send */
                    $total_sent = $blockcypher['address_details']->total_sent;

                    if($blockcypher['address_details']->currency == 'btc'){
                        $total_sent = round($blockcypher['address_details']->total_sent/config('constants.blockcypher.amount.btc'), 4).' BTC';

                    }elseif($blockcypher['address_details']->currency == 'eth'){
                        $total_sent = round($blockcypher['address_details']->total_sent/config('constants.blockcypher.amount.eth'), 4).' ETH';
                    }

                    /* incoming txn */
                    $incoming_txn = $blockcypher['address_details']->incoming_txn;

                    /* total txn */
                    $total_txn = $blockcypher['address_details']->total_txn;

                    /* outgoing txn */
                    $outgoing_txn = $blockcypher['address_details']->outgoing_txn;

                    $text = "<b>".$currency."</b> <b>Address</b>: ".$response['keyword']."

                    ⬇️Free results⬇️

                    <b>Low risk address</b> 👍 
                    <b>Risk</b>: ".$risk_score."

                    Belongs to cluster: MEXC Exchange (prev. MXC Exchange)

                    ⬇️Available after payment⬇️

                    Detailed analysis of more than 25 sources:

                    ✅ Low risk
                    •   Exchange - ??%

                    ⬇️General information⬇️

                    <b>Balance</b>: ".$balance."

                    <b>Transactions</b>: ".$total_txn."
                    <b>First activity</b>: ".$first_seen_at."
                    <b>Last tx</b>: ".$last_seen_at."
                    <b>Total received</b>: ".$total_received."
                    <b>Total sent</b>: ".$total_sent."

                    <b>PDF report</b> - (available after your payment)
                    To see the sources and download the PDF report, pay for a full check👇
                    ______________________________________

                    Checked by spyderlab.org (https://www.spyderlab.org/)
                    SpyderlabBot (https://t.me/sonihai290195_bot)
                    ";

                }else{

                    $text = 'Oop`s something went wrong please try later.';

                }

                $response = $telegramService->sendMessage($updates_value['message']['chat']['id'],$text,$keyboard);

                /* Reduce the no of requests form user subscription*/
                if($response['ok'] == true){

                    $tg_user = TelegramUser::where('telegram_id',$updates_value['message']['from']['id'])->first();

                    $tg_subscription = TelegramSubscription::where('user_id',$tg_user->id);

                    if($tg_subscription->count() > 0){

                        $tg_updated_sub = $tg_subscription->first();

                        $tg_updated_sub->no_of_request = ($tg_subscription->no_of_request - 1);
                        $tg_updated_sub->save();

                    }

                }



            }elseif($updates_value['message']['text'] == 'Top up'){

                $keyboard = array();
                $text = '';

                $check_user = TelegramUser::where('telegram_id',$updates_value['message']['from']['id']);

                /* remove the temporary chat if it exist */
                TelegramTmpChat::where('tm_user_id',$updates_value['message']['from']['id'])->delete();

                if($check_user->count()>0){

                    $user_info = $check_user->first();

                    $check_sub = TelegramSubscription::where('user_id',$user_info->id);

                    if($check_sub->count() > 0){

                        $sub_info = $check_sub->first();

                        if(!is_null($sub_info->no_of_request) || $sub_info->no_of_request > 0){

                            $keyboard = [
                                ['Custom Amount', 'Package']
                            ];

                            $text = "You have ".$sub_info->no_of_request." requests on your balance.
                            Please select your payment method:";
                        }else{

                            $keyboard = [
                                ['Custom Amount', 'Package']
                            ];

                            $text = "You have 0 requests on your balance.
                            Please select your payment method:";
                        }
                    }else{

                        $keyboard = [
                            ['Custom Amount', 'Package']
                        ];

                        $text = "please take a sutable plan and enjoy our services";

                    }
                }else{

                    $text = "system upable to reconige you please click /start to start process again";
                }

                $telegramService->sendMessage($updates_value['message']['chat']['id'],$text,$keyboard);

            }elseif(in_array($updates_value['message']['text'],array('Package','Custom Amount'))){

                /* store this text message in db */

                if($updates_value['message']['text'] == 'Package'){

                    $tmp_arr = [
                        'tm_user_id'=>$updates_value['message']['from']['id'],
                        'sub_type'=> 'package',
                    ];

                }else{

                    $tmp_arr = [
                        'tm_user_id'=>$updates_value['message']['from']['id'],
                        'sub_type'=> 'custom',
                    ];

                }
                TelegramTmpChat::Create($tmp_arr);

                if($updates_value['message']['text'] == 'Package'){

                    if(count($full_package) > 0){
                        $text = 'Please, select a package 👇';
                    }else{
                        $text = 'Oop`s currently you have not any package please use custom package option 👇';
                    }

                    $keyboard = $full_package;

                }else{

                    $text = 'Please specify the number of checks you would like to prepay';
                    $keyboard = array();
                }

                $telegramService->sendMessage($updates_value['message']['chat']['id'],$text,$keyboard);

            }elseif(isset($check_tmp_package)){


                if( ($check_tmp_package->sub_type == 'package') AND in_array($updates_value['message']['text'],$mearge_full_package)){

                    /* store this text message in db */

                    $package_arr = explode('per',$updates_value['message']['text']);

                    $no_of_req = $package_arr[0];
                    $price = (int)trim(str_replace("$","", (string)$package_arr[1]));

                    $package_info = TelegramPackage::where(['no_of_request'=>$no_of_req,'price'=>$price])->first();

                    if($package_info->count() > 0){

                        $tmp_chat_data = ['amount'=>$price,'no_of_request'=>(int)$no_of_req,'package_id'=>$package_info->id];

                    }else{

                        $tmp_chat_data = ['amount'=>$price,'no_of_request'=>(int)$no_of_req];

                    }

                    $getUserLast_row = TelegramTmpChat::where('tm_user_id',$updates_value['message']['from']['id'])->orderBy('id','desc')->first();

                }else{


                    $getUserLast_row = TelegramTmpChat::where('tm_user_id',$updates_value['message']['from']['id'])->orderBy('id','desc')->first();

                    $no_of_req = $updates_value['message']['text'];
                    $price = $updates_value['message']['text']*\Config::get('constants.telegram_custom_amount');

                    $tmp_chat_data = ['amount'=>$price,'no_of_request'=>(int)$no_of_req];
                }

                TelegramTmpChat::where('id',$getUserLast_row->id)->update($tmp_chat_data);


                $text_one = 'The tariff includes
                <b>✓ '.$no_of_req.' address checks, unlimited in time
                ✓ 24/7 customer support</b>';

                $text_two = 'Please, specify asset for pay '.$no_of_req.' per '.'$'.$price.' package:';

                $text_three = 'After specifying the currency, you will get an address for transfer funds';

                if($price > 20){

                    $inlineKeyboard = [
                        [
                            [
                                "text" => "BTC",
                                "callback_data" => 'btc'
                            ],
                            [
                                "text" => "ETH",
                                "callback_data" => 'eth'
                            ],
                            [
                                "text" => "LTCT",
                                "callback_data" => 'ltct'
                            ],
                        ]
                    ];

                }else{

                    $inlineKeyboard = [
                        [
                            [
                                "text" => "BTC",
                                "callback_data" => 'btc'
                            ],
                            [
                                "text" => "LTCT",
                                "callback_data" => 'ltct'
                            ],
                        ]
                    ];
                }

                $keyboard = [
                    ['Check', 'Top up'],
                    ['Investigation', 'Tracking']
                ];

                $telegramService->sendMessage($updates_value['message']['chat']['id'],$text_one,null,array());

                $telegramService->sendMessage($updates_value['message']['chat']['id'],$text_two,null,$inlineKeyboard);

                $telegramService->sendMessage($updates_value['message']['chat']['id'],$text_three,$keyboard,null);

            }else{

                $keyboard = array();
                $text = "Failed to recognize the command. Please use /menu or the help buttons.";
                $telegramService->sendMessage($updates_value['message']['chat']['id'],$text,$keyboard);

            }

        }




        // if(count($updates['result'])<1){
        //     return false;
        // }

        // foreach ($updates['result'] as $updates_value) {

        // }

        // $telegramService->sendMessage($updates_value['message']['chat']['id'],'Hello',array());

     // $telegramService = app(TelegramService::class);
     // \Log::info($telegramService->getWebhookUpdate());
     //  // dd($request->all());
    }

    // public function  setTelegramWebHook(){
    // $telegramService = app(TelegramService::class);
    // $telegramService->setWebhook('https://www.spyderlab.org/7508678190:AAGhG6Q2QtFC-HtQs3Vy-gAxWIhwwqV-z0g/telegram-bot','ssl_certificate /etc/nginx/ssl/public/spydercet.com.pem');

    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\telegramPackage  $telegramPackage
     * @return \Illuminate\Http\Response
     */
    public function show(telegramPackage $telegramPackage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\telegramPackage  $telegramPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(telegramPackage $telegramPackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\telegramPackage  $telegramPackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, telegramPackage $telegramPackage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\telegramPackage  $telegramPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(telegramPackage $telegramPackage)
    {
        //
    }
}
