<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SearchByPhoneRequest;
use App\Http\Requests\SearchByEmailRequest;
use Auth;

class SearchController extends Controller
{
    public function __construct() {
        $this->middleware(['auth','verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $seoData = \App\Models\Seo::where('slug','search')->first();

        /* Countries */
        $countries = $this->get_countries();

        if($request->method() == 'POST'){

            //Validate request

            if($request->get('search_by') == '' || !in_array($request->get('search_by'), ['phone', 'email'])){
                
                return view('frontend.account.osint', ['countries' => $countries, 'country_code' => 'IN', 'phone_number' => '', 'details_by_phone' => null]);
                
                // return view('frontend.search', ['countries' => $countries, 'country_code' => 'IN', 'phone_number' => '', 'details_by_phone' => null]);                

            }

            if($request->get('search_by') == 'phone'){
                app(SearchByPhoneRequest::class);
            }else{
                app(SearchByEmailRequest::class);
            }

            /* Check KYC */
            if(isset(is_kyc_mandatory()->kyc_mandatory)){

              if(is_kyc_mandatory()->kyc_mandatory == 'Y'){
                
                if(is_null(Auth::user()->kyc_verified_at)){
                   return redirect()->route('search.index')->with(['status' => 'danger', 'message' => 'Your account is disabled for this service. It will be enabled after ID verification. Please contact us at '.config('mail.kyc_verification_mail').'.']);
               }
           }
       }

       $available_credits = available_credits();
       if($available_credits == 0){
        return redirect()->route('search.index')->with(['status' => 'danger', 'message' => 'You doesn\'t have enough credit, please buy it from &nbsp;<a href="'.route('pricing').'" class="text-white">Pricing</a>']);
    }

    if($request->get('search_by') == 'email'){

        /* deduct credit for search */
        $this->deduct_credit(auth()->user()->id);
        
        return redirect(route('advance-search').'?email='.$request->get('email'));
    }

    $search_data = $this->search_by_phone($request);
    $search_data = json_decode($search_data);

    // return view('frontend.search', ['countries' => $countries, 'country_code' => $request->get('country_code'), 'phone_number' => $request->get('phone_number'), 'details_by_phone' => $search_data, 'seoData'=> $seoData]);

    return view('frontend.account.osint', ['countries' => $countries, 'country_code' => $request->get('country_code'), 'phone_number' => $request->get('phone_number'), 'details_by_phone' => $search_data, 'seoData'=> $seoData]);

}else{
    // return view('frontend.search', ['countries' => $countries, 'country_code' => 'IN', 'phone_number' => '', 'details_by_phone' => null, 'seoData'=> $seoData]);

       return view('frontend.account.osint', ['countries' => $countries, 'country_code' => 'IN', 'phone_number' => '', 'details_by_phone' => null, 'seoData'=> $seoData]);
}
}

public function advanceSearch(Request $request){

    $seoData = \App\Models\Seo::where('slug','search')->first();
    $email = $request->get('email') ?? '';

    $error_message = '';
    if(!$request->has('email')){
        $error_message = "Invalid url, required parameter:email.";
    }elseif($email == ''){
        $error_message = "Invalid url, email should not be empty";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format";
    }

            /* Countries */
    $countries = $this->get_countries();

    if($error_message != ''){
        //return view('frontend.advance-search', ['email' => $email, 'error_message' => $error_message, 'connected_accounts' => null, 'seoData'=> $seoData]);

        return view('frontend.account.advance-search', ['countries' => $countries,'country_code' => 'IN','email' => $email, 'phone_number' => '','error_message' => $error_message, 'connected_accounts' => null, 'seoData'=> $seoData]);
    }else{

        $connected_accounts = $this->search_by_email($email);

        return view('frontend.account.advance-search', ['countries' => $countries,'country_code' => 'IN','email' => $email, 'phone_number' => '','error_message' => '', 'connected_accounts' => json_decode($connected_accounts), 'seoData'=> $seoData]);
    }
}
}
