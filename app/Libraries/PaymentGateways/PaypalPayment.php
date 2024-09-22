<?php

namespace App\Libraries\PaymentGateways;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

use App\Models\Transaction;

class PaypalPayment {

    public function checkout($user, $plan_info, $terms_in_month){

        $price = round($plan_info->monthly_price * $terms_in_month , 2);	

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        
        $paypalToken = $provider->getAccessToken();
        
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('checkout.success', 'paypal'),
                "cancel_url" => route('checkout.cancel', 'paypal'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $price
                    ]
                ]
            ]
        ]);

        return $response;
    }

    public function get_order($token){
      $provider = new PayPalClient;
      $provider->setApiCredentials(config('paypal'));
      $provider->getAccessToken();
      
      $response = $provider->capturePaymentOrder($token);

      return $response;
  }
}