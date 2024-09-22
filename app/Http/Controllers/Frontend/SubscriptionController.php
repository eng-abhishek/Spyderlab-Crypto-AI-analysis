<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Plan;
use App\Models\CryptoPlan;
use App\Models\CryptoPlanSubscription;
use App\Models\CryptoPlanTransaction;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Libraries\PaymentGateways\PaypalPayment;
use App\Libraries\PaymentGateways\StripePayment;
use App\Libraries\PaymentGateways\CoinPayment;

class SubscriptionController extends Controller
{

	private $stripe_payment;
	private $paypal_payment;
	private $coin_payment;

	public function __construct() {
		$this->stripe_payment = new StripePayment();
		$this->paypal_payment = new PaypalPayment();
		$this->coin_payment = new CoinPayment();
	}


	public function purchase(Request $request){
		if(!(\Auth::user())){

			return redirect()->route('login');

		}else{

			$raw_info = CryptoPlan::where('slug',$request->get('plan'))->first();
			
			if($raw_info->count() < 1){

				return redirect()->route('pricing')->with(['status' => 'danger', 'message' => 'Oop`s this plan not avaliable right now.']);

			}
			
			$data['crypto_plan'] = CryptoPlan::where('is_active','Y')->get();
			
			$data['record'] = $raw_info->first();

			return view('frontend.checkout',$data);
		}
	}

	public function subscribe(Request $request){
		
		try{
			\DB::beginTransaction();

			$terms_in_month = $request->get('terms_in_month');

			if(empty($request->input('payment-gateway'))){
				
				return redirect()->back()->with(['status'=>'danger','message'=>'Oop`s please select payment method.']);

			}

			$info = CryptoPlanSubscription::withCount('paid_plans')->where(['user_id'=>\Auth::user()->id,'is_active'=>'Y'])->where('expired_date','>=',Carbon::now())->orderBy('id','desc')->first();
			
			$user = User::with('subscription.plans')->where('id',\Auth::user()->id)->first();
			
			$raw_info = CryptoPlan::where(['id'=>$request->get('plan_id'),'is_active'=>'Y']);

			if($raw_info->count() < 1){

				return redirect()->route()->with(['status'=>'danger','message'=>'Oops something went wrong.']);
			}
			
			$plan_info = $raw_info->first();

			
			if(!is_null($user->subscription)){

				if($plan_info->slug == $user->subscription->plans->slug){
					
					$to_date = now()->addDays(7)->format('Y-m-d');

					if($user->subscription->expired_date > $to_date){

						return redirect()->route('account.profile.subscription')->with(['status' => 'danger', 'message' => 'Plan you are selected is already active, you can\'t renew your subscription before 7 day of expiry.']);
					}
				}
			}
			
			/* check user plan type */

			if(!is_null($user->subscription)){

				if($plan_info->slug == $user->subscription->plans->slug){

					if($request->get('terms_in_month') == $user->subscription->terms_in_month){

						$subscription_type = 'R';

					}elseif($request->get('terms_in_month') > $user->subscription->terms_in_month){

						$subscription_type = 'U';

					}elseif($request->get('terms_in_month') < $user->subscription->terms_in_month){

						$subscription_type = 'D';

					}else{
						$subscription_type = 'N';
					}
				}elseif($request->get('terms_in_month') > $user->subscription->terms_in_month){

					$subscription_type = 'U';

				}elseif($request->get('terms_in_month') < $user->subscription->terms_in_month){
					$subscription_type = 'D';

				}else{
					$subscription_type = 'N';
				}
			}else{
				$subscription_type = 'N';
			}

			$plan_price = round($plan_info->monthly_price * $terms_in_month,2);


			if($request->get('payment-gateway') == 'paypal'){

				$response = $this->paypal_payment->checkout($user, $plan_info,$terms_in_month);

				CryptoPlanTransaction::Create([
					'transaction_id' => $response['id'],
					'plan_id' => $plan_info->id,
					'plan_type' => $plan_info->plan_type,
					'plan_change_type' => $subscription_type,
					'user_id' => Auth::user()->id,
					'purchese_price' => $plan_price,
					'final_price' => $plan_price,
					'terms_in_month'=> $request->get('terms_in_month'),
					'payment_gateway_id' => 'paypal',
					'status' => 'Pending',
					'created_by' => Auth::user()->id,
				]);

				if (isset($response['id']) && $response['id'] != null) {

					foreach ($response['links'] as $links) {
						if ($links['rel'] == 'approve') {
							\DB::commit();
							return redirect()->away($links['href']);
						}
					}
					return redirect()->route('purchase', ['plan' => $plan_info->slug])->with(['status' => 'danger', 'message' => 'Something went wrong, please try again later.']);
				} else {
					return redirect()->route('purchase', ['plan' => $plan_info->slug])->with(['status' => 'danger', 'message' => $response['message'] ?? 'Something went wrong, please try again later.']);
				}
			}elseif($request->get('payment-gateway') == 'stripe'){

				$response = $this->stripe_payment->checkout($user, $plan_info,$terms_in_month);
				
				CryptoPlanTransaction::Create([
					'transaction_id' => $response['id'],
					'plan_id' => $plan_info->id,
					'plan_type' => $plan_info->plan_type,
					'plan_change_type' => $subscription_type,
					'user_id' => Auth::user()->id,
					'purchese_price' => $plan_price,
					'final_price' => $plan_price,
					'terms_in_month'=> $request->get('terms_in_month'),
					'payment_gateway_id' => 'stripe',
					'status' => 'Pending',
					'created_by' => Auth::user()->id,
				]);

				\DB::commit();
				return redirect()->away($response['url']);

			}elseif( in_array($request->get('payment-gateway'), ['btc','eth'])){
				
				$currency1 = 'USD';
				$currency2 = strtoupper($request->get('payment-gateway'));
				
				$total_amount = round($plan_info->monthly_price * $terms_in_month , 2);
				
				$discount_amount = 0;

				$total_payable_amount = $total_amount - $discount_amount;

				$response = $this->coin_payment->create_transaction($user,$plan_info,$total_payable_amount, $currency1, $currency2);

				if($response['error'] != 'ok'){

					return redirect()->route('purchase', ['plan' => $plan_info->slug])->with(['status' => 'danger', 'message' => $response['message'] ?? 'Something went wrong, please try again later.']);
				}

				/* Calculate coinpayment timeout */
				$created_at = now();
				$coinpayment_expired_at = $created_at->copy()->addSeconds($response['result']['timeout'])->format('Y-m-d H:i:s');

				$transaction = CryptoPlanTransaction::Create([
					'transaction_id' => $response['result']['txn_id'],
					'plan_id' => $plan_info->id,
					'plan_type' => $plan_info->plan_type,
					'plan_change_type' => $subscription_type,
					'user_id' => Auth::user()->id,
					'currency_type' => 'crypto',
					'purchese_price' => $plan_price,
					'terms_in_month'=> $request->get('terms_in_month'),
					'payment_gateway_id' => 'ltct',
					'coinpayment_address' => $response['result']['address'],
					'coinpayment_expired_at' => $coinpayment_expired_at,
					'coinpayment_qrcode_url' => $response['result']['qrcode_url'],
					'final_price' => $plan_price,
					'final_price_in_crypto' => $response['result']['amount'],
					'status' => 'Pending',
					'currency' => strtoupper($currency2),
					'created_by' => Auth::user()->id,
				]);

				\DB::commit();
				return redirect()->route('coinpayment-checkout', $transaction->id);

			}else{
				return redirect()->route('pricing')->with(['status' => 'danger', 'message' =>'Something went wrong, please try again later.']);
			}
		}catch(\Exception $e){

			return redirect()->route('pricing')->with(['status' => 'danger', 'message' =>'Something went wrong, please try again later.']);

		}
	}

	public function success(Request $request, $payment_gateway, $txn_id=null)
	{
       try{
		
		\DB::beginTransaction();

		if($payment_gateway == 'stripe'){

			$session_id = $request->get('session_id');
			$response = $this->stripe_payment->get_session($session_id);

			if (!$response || $response['status'] != 'complete') {

				return redirect()->route('pricing')->with(['status' => 'danger', 'message' => 'Payment failed.']);
			}

			$transaction_id = $response->id;
			$payment_id = $response->payment_intent;

			$payer_id = null;
			$payer_email =  null;

		}elseif($payment_gateway == 'paypal'){

			$token = $request->get('token');
			$response = $this->paypal_payment->get_order($token);
			$transaction_id = $response['id'];

			$paypal_payment_obj = $response['purchase_units'][0]['payments']['captures'][0];
			$payment_id = $paypal_payment_obj['id'];

			$payer_id = $response['payer']['payer_id'] ?? null;
			$payer_email = $response['payer']['email_address'] ?? null;

		}elseif($payment_gateway == 'crypto'){
			$transaction_id = $txn_id;
			$payment_id = null;

			$payer_id = null;
			$payer_email =  null;
		}

		$transaction = CryptoPlanTransaction::where('transaction_id', $transaction_id)->first();

		if (!$transaction) {
			
			return redirect()->route('pricing')->with(['status' => 'danger', 'message' => 'Payment failed.']);
		}

		$plan_info = CryptoPlan::where('id',$transaction->plan_id)->first();


		/*--- InActive previous subscription of this user ------*/
		$get_previous_subscription  = CryptoPlanSubscription::where(['user_id'=>\Auth::user()->id])->orderBy('id','desc')->first();

		if(!is_null($get_previous_subscription) AND (($transaction->plan_change_type == 'U') OR ($transaction->plan_change_type == 'D'))){


			$subscription_info = CryptoPlanSubscription::where(['user_id'=>\Auth::user()->id,'is_active'=>'Y'])->orderBy('id','desc')->first();
			
			$start_at = now();
			$old_end_at = Carbon::parse($subscription_info->expired_date);
			
			$end_at = $old_end_at->copy()->addMonths($transaction->terms_in_month);

			$create_subscription = [
				'plan_id' => $plan_info->id,
				'purchese_price' => $transaction->purchese_price,
				'plan_type' => $plan_info->plan_type,
				'updated_by' => Auth::user()->id,
				'terms_in_month'=> $transaction->terms_in_month,
				'started_date'=> Carbon::now(),
				'expired_date'=> $end_at,
			];

			CryptoPlanSubscription::where('id',$get_previous_subscription->id)->update($create_subscription);

		  $sub_id = $get_previous_subscription->id;

		}else{

			$end_at = Carbon::now()->addMonths($transaction->terms_in_month);

			$create_subscription = CryptoPlanSubscription::Create([
				'user_id' => Auth::user()->id,
				'plan_id' => $plan_info->id,
				'purchese_price' => $transaction->purchese_price,
				'plan_type' => $plan_info->plan_type,
				'created_by' => Auth::user()->id,
				'updated_by' => Auth::user()->id,
				'terms_in_month'=> $transaction->terms_in_month,
				'started_date'=> Carbon::now(),
				'expired_date'=> $end_at,
			]);

		     $sub_id = $create_subscription->id;
		}

		if ($transaction->status == 'Pending') {

			$transaction->payment_id = $payment_id;
			$transaction->sub_id  =  $sub_id;               
			$transaction->payment_id = $payment_id;
			$transaction->payer_id = $payer_id;
			$transaction->payer_email = $payer_email;
			$transaction->status = 'Paid';
			$transaction->save();
		}

		\DB::commit();

		return redirect()->route('account.profile.subscription')->with(['status' => 'success', 'message' =>'Your transaction has been completed successfully.']);

       }catch(\Exception $e){

          return redirect()->route('pricing')->with(['status' => 'danger', 'message' =>'Oop`s something went wrong, please connect to support.']);

       }
	}

	public function getAmountSummery(Request $request){
        
        // dd($request->all());

		$plan_id = $request->get('plan_id');
		$months = $request->get('months');

		$user = User::where('id',\Auth::user()->id)->first();

		$plan_info = CryptoPlan::where('id',$plan_id)->first();
		
		$total_amount = round($plan_info->monthly_price * $months , 2);
		
		$discount_amount = 0;

		$total_payable_amount = $total_amount - $discount_amount;

		if(in_array(strtolower($request->get('coin_type')),['btc','eth'])){
			
			$currency1 = 'USD';
			$currency2 = strtoupper($request->get('coin_type'));

			$response = $this->coin_payment->create_transaction($user,$plan_info,$total_payable_amount, $currency1, $currency2);        

			if($response['error'] != 'ok'){
				return response()->json(['status' => 'danger', 'message' => $response['error'] ?? 'Something went wrong, please try again.']);
			}

			$data = array(
				'total_amount' => "$".$total_amount,
				'discount_amount' => "$".$discount_amount,
				'total_payable_amount' => $response['result']['amount'] ." ".strtoupper($request->get('coin_type')),
			);

		}else{
			
			$data = array(
				'total_amount' => "$".$total_amount,
				'discount_amount' => "$".$discount_amount,
				'total_payable_amount' => "$".$total_payable_amount,
			);
		}

		return response()->json(['status' => 'success', 'message' => $data]);

	}

	public function cancel(Request $request)
	{
		return redirect()->route('pricing')->with(['status' => 'danger', 'message' => 'Payment cancelled.']);
	}


	public function changeUserSubscription(Request $response){
		
		try{

			$check_sub = CryptoPlanSubscription::where('user_id',\Auth::user()->id)->first();
			$plan_id = $check_sub->plan_id;
			$previous_plan = CryptoPlan::where('id',$plan_id)->first();

			if($response->get('type') == 'upgrade'){
				
				$next_plan = CryptoPlan::where('monthly_price','>',$previous_plan->monthly_price)->take(1)->orderBy('monthly_price','asc')->first();

			}elseif($response->get('type') == 'downgrade'){

				$next_plan = CryptoPlan::where('monthly_price','<',$previous_plan->monthly_price)->take(1)->where('is_free','N')->orderBy('monthly_price','asc')->first();

			}else{
				
				$next_plan = CryptoPlan::where('slug',$previous_plan->slug)->first();

			}
			
			return redirect()->route('purchase',['plan'=>$next_plan->slug]);

		}catch(\Exception $e){
			return redirect()->route('account.profile.subscription')->with(['status'=>'danger','message'=>'Oop`s something went wrong.']);
		}
	}

}
?>