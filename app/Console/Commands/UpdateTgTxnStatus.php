<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\PaymentGateways\CoinPayment;
use App\Models\TelegramSubscription;
use App\Models\TelegramTransaction;

class UpdateTgTxnStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:telegram_txn_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update txn successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->coin_payment = new CoinPayment();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $get_txn_list = TelegramTransaction::where('txn_status','Pending')->get();
        
        foreach($get_txn_list as $key=> $get_txn_val){
        
        // dd($get_txn_val);
        $response = $this->coin_payment->get_tx_info($get_txn_val->txn_id);
        // dd($response);
        if($response['error'] == 'ok'){

        if ($response['result']['status'] >= 100 || $response['result']['status'] == 2) {
        
        /* get transaction */
        $transaction = TelegramTransaction::where('txn_id',$get_txn_val->txn_id)->first();
        
        $check_subscription = TelegramSubscription::where('user_id',$transaction->user_id);
        
        $subscription_array  = [
                'package_id' => $transaction->package_id,
                'sub_type' => $transaction->sub_type,
                 ];

        if($check_subscription->count() > 0){
         
        /* update user subscription */

        $subscription_info = $check_subscription->first();
        
        /* add on no of request (no of search address) */
         
        $subscription_array['no_of_request'] = ($subscription_info->no_of_request + $transaction->no_of_request);

        TelegramSubscription::where('user_id',$subscription_info->user_id)->update($subscription_array);
        
        $sub_id = $subscription_info->id;
        
        }else{
        
        $subscription_array['no_of_request'] = $transaction->no_of_request;
        $subscription_array['user_id'] = $transaction->user_id;

        /* add subscription */
        $create_subscription = TelegramSubscription::Create($subscription_array);
        $sub_id = $create_subscription->id;
        }

        /* update transaction */
        $transaction->txn_status = 'Paid';
        $transaction->sub_id = $sub_id;
        $transaction->save();

        }
        }
        }
    }
}
