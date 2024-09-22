<?php

namespace App\Libraries\PaymentGateways;

class StripePayment {

	private $stripe;

	public function __construct() {
		$this->stripe = new \Stripe\StripeClient(config('stripe.stripe_secret'));
	}

	public function checkout($user, $plan_info, $terms_in_month){
		
		$price = round($plan_info->monthly_price * $terms_in_month , 2);

		$response =  $this->stripe->checkout->sessions->create([
			'line_items' => [
				[
					'price_data' => [
						'product_data' => [
							'name' => $plan_info->name,
						],
						'unit_amount' => 100 * $price,
						'currency' => 'USD',
					],
					'quantity' => 1
				],
			],
			'payment_method_types' => ['card'],
			'mode' => 'payment',
			'allow_promotion_codes' => true,
			'success_url' => route('checkout.success', 'stripe')."?session_id={CHECKOUT_SESSION_ID}",
			'cancel_url' => route('checkout.cancel', 'stripe'),
			'customer_email' => $user->email
		]);

		return $response;
	}

	public function get_session($session_id){
		
		$response =  $this->stripe->checkout->sessions->retrieve($session_id);

		return $response;
	}
}