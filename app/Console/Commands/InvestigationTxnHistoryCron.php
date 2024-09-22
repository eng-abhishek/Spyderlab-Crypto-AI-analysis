<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Investigation;
use App\Models\InvestigationTxnHistory;
use App\Libraries\Blockcypher;
use Carbon\Carbon;
use Auth;
use DataTables;

class InvestigationTxnHistoryCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investigation-txn-history:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage investigation txn history';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
    	parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
    	try{
            
            $user_id = \Auth::user()->id;

            $available_plan = \App\Models\CryptoPlanSubscription::where('user_id', $user_id)->where('expired_date', '>=', now())->orderBy('id','desc')->where('is_active','Y')->first();

            if(!is_null($available_plan)){

            $monitoring = Investigation::where('is_active','Y')->get();

            /*-------- Check Today Txn ---------*/

            foreach($monitoring as $value){

                $address = $value->address;
                $token = $value->token;

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

              //$total_txn =  $blockcypher->total_txn;

                    $transactions = [];
                    $arr_txn = collect($blockcypher->transactions);

                    $last_one_hours_txn = $arr_txn->where('confirmed_at', '>', 
                        Carbon::now()->subHours(10)->toDateTimeString()
                    );
               //dd($last_one_hours_txn);
                    $total_txn = $last_one_hours_txn->count();

                    foreach($last_one_hours_txn as $key => $txn){
                        
                        $confirmed_date = Carbon::parse($txn->confirmed_at)->format('Y-m-d');
                //$confirmed_date = Carbon::parse(Carbon::Today())->format('Y-m-d');
                        $current_date = Carbon::parse(Carbon::Today())->format('Y-m-d');

                        $date1 = strtotime($confirmed_date);
                        $date2 = strtotime($current_date);
                // echo $date1."<br>";
                // echo $date2;
                        if($date1 == $date2){
                            if($key < 2){
                                
                                if(isset($txn->confirmed_at)){

                                    if($blockcypher_details->response->currency == 'btc'){

                                        $amount = number_format($txn->amount/100000000,8).' BTC';

                                    }elseif($blockcypher_details->response->currency == 'eth'){

                                        $amount = number_format($txn->amount/1000000000000000000,15).' ETH';

                                    }elseif($blockcypher_details->response->currency == 'xmr'){

                                        $amount = number_format($txn->amount/1000000000000,8).' XMR';

                                    }elseif($blockcypher_details->response->currency == 'bnb'){

                                        $amount = number_format($txn->amount/1000000000000000000,15).' BNB';

                                    }elseif($blockcypher_details->response->currency == 'xrp'){

                                        $amount = number_format($txn->amount/1000000,6).' XRP';

                                    }elseif($blockcypher_details->response->currency == 'sol'){

                                        $amount = number_format($txn->amount/1000000000 ,8).' SOL';

                                    }elseif($blockcypher_details->response->currency == 'ada'){

                                        $amount = number_format($txn->amount/1000000,6).' ADA';

                                    }else{
                                        $amount = $txn->amount;
                                    }
                                    $transactions[] = [
                                        'txn_id' => $txn->txn_id,
                                        'txn_has' => $txn->block_hash,
                                        'txn_time' => $txn->confirmed_at,
                                        'txn_amount' => $amount, 
                                        'token' => $token,
                                        'address' => $address,
                                        'created_at' => Carbon::now(),
                                    ];
                                }
                            }
                        }
                    }
                    /*----------  Insert in db ----------*/
                    
                    if(count($transactions)>0){
                        
                        InvestigationTxnHistory::insert($transactions);
                        
                    }
                    /*------------ Send Email --------*/
                }
            }
            }
    		/*-------- Check Today Txn ---------*/
    	}catch(\Exception $e){

    		\Log::error('Cron - Txn: '.$e->getMessage());
    	}
    }
}
