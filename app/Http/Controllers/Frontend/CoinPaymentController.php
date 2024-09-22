<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CryptoPlan;
use App\Models\CryptoPlanSubscription;
use App\Models\CryptoPlanTransaction;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Libraries\PaymentGateways\CoinPayment;

class CoinPaymentController extends Controller
{
    private $coin_payment; 

    public function __construct() {
        $this->coin_payment = new CoinPayment();
    }

    /**
     * Get converted amount (Ajax).
     *
     * @return \Illuminate\Http\Response
     */
    
    public function checkout(Request $request, $transaction_id){
        
        //dd($request->all());
        $user = \Auth::user();

        $transaction = CryptoPlanTransaction::find($transaction_id);

        if(!$transaction){
            return redirect()->route('pricing')->with(['status' => 'danger', 'message' => 'Page not found.']);
        }

        if($transaction->user_id != $user->id){
            return redirect()->route('pricing')->with(['status' => 'danger', 'message' => 'Page not found.']);
        }

        if($transaction->currency_type != 'crypto'){
            return redirect()->route('pricing')->with(['status' => 'danger', 'message' => 'Page not found.']);
        }

        if($transaction->status == 'Paid'){
            return redirect()->route('account.index')->with(['status' => 'success', 'message' => 'Transaction already completed.']);
        }

        $response = $this->coin_payment->get_tx_info($transaction->transaction_id);

        // dd($response);

        if($response['error'] != 'ok'){
            return redirect()->route('pricing')->with(['status' => 'danger', 'message' => $response['error'] ?? 'Something went wrong, please try again.']);
        }
        $status = intval($response['result']['status']);
        $coinpayment_status = '';

        if ($status >= 100 || $status == 2) {
            $coinpayment_status = 'completed';
            return redirect()->route('checkout.success', ['payment_gateway' => 'crypto', 'txn_id' => $transaction->transaction_id]);
        } else if ($status < 0) {
            $coinpayment_status = 'timeout';
            // $coinpayment_status = 'cancelled';
        } else {
            $coinpayment_status = 'pending';
        }

        $coinpayment_expired_at = Carbon::parse($transaction->coinpayment_expired_at);
        $diff = $coinpayment_expired_at->diff(now());
        $time_remaining = $diff->format('%H:%I:%S');

        return view('frontend.coinpayment-checkout', [
            'transaction' => $transaction,
            'coinpayment_status' => $coinpayment_status,
            'time_remaining' => $time_remaining
        ]);

    }

    public function ipn(Request $req){

        $txn_id = $_POST['txn_id'];
        $item_name = $_POST['item_name'];
        $item_number = $_POST['item_number'];
        $amount1 = floatval($_POST['amount1']);
        $amount2 = floatval($_POST['amount2']);
        $currency1 = $_POST['currency1'];
        $currency2 = $_POST['currency2'];
        $status = intval($_POST['status']);
        $status_text = $_POST['status_text'];


        $cp_merchant_id   = config('constants.coinpayment.merchant_id');
        $cp_ipn_secret    = config('constants.coinpayment.ipn_secret');
        $cp_debug_email   = config('constants.coinpayment.ipn_debug_email');

        /* Filtering */
        if(!empty($req->merchant) && $req->merchant != trim($cp_merchant_id)){
            // if(!empty($cp_debug_email)) {
            //     \Mail::to($cp_debug_email)->send(new SendEmail([

            //         'message' => 'No or incorrect Merchant ID passed'
            //     ]));
            // }
            // return response('No or incorrect Merchant ID passed', 401);
            \Log::info('Coinpayment : No or incorrect Merchant ID passed');
        }
        $request = $req->getContent();
        if ($request === FALSE || empty($request)) {
            // if(!empty($cp_debug_email)) {
            //     \Mail::to($cp_debug_email)->send(new SendEmail([

            //         'message' => 'Error reading POST data'
            //     ]));
            // }
            // return response('Error reading POST data', 401);
            \Log::info('Coinpayment : Error reading POST data');
        }
        $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret));
        if (!hash_equals($hmac, $req->server('HTTP_HMAC'))) {
            // if(!empty($cp_debug_email)) {
            //     \Mail::to($cp_debug_email)->send(new SendEmail([
            //         'message' => 'HMAC signature does not match'
            //     ]));
            // }
            // return response('HMAC signature does not match', 401);
            \Log::info('Coinpayment : HMAC signature does not match');
        }

        $transactions = CoinpaymentTransaction::where('txn_id', $req->txn_id)->first();

        if($transactions){

            // $info = $this->api_call('get_tx_info', ['txid' => $req->txn_id]);
            // $info = $this->coin_payment->get_tx_info($req->txn_id);

            // if($info['error'] != 'ok'){
                // \Mail::to($cp_debug_email)->send(new SendEmail([
                //     'message' => date('Y-m-d H:i:s ') . $info['error']
                // ]));
                // \Log::info('Coinpayment : '.$info['error']);
            // }
            // \Log::info($info);exit;

            // try {
                // $transactions->update($info['result']);
            // } catch (\Exception $e) {
                // \Mail::to($cp_debug_email)->send(new SendEmail([
                //     'message' => date('Y-m-d H:i:s ') . $e->getMessage()
                // ]));

                // \Log::info('Coinpayment : '.$e->getMessage());
            // }

            // dispatch(new CoinpaymentListener(array_merge($transactions->toArray(), [
            //     'transaction_type' => 'old'
            // ])));
            \Log::info($status);
            \Log::info($status_text);
            die();

        } else {
            if(!empty($cp_debug_email)) {
                // \Mail::to($cp_debug_email)->send(new SendEmail([
                //     'message' => 'Txn ID ' . $req->txn_id . ' not found from database ?'
                // ]));
                \Log::info('Coinpayment : Txn ID ' . $req->txn_id . ' not found from database ?');
            }
        }
    }
}
