<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SearchByPhoneRequest;
use App\Models\Plan;
use App\Models\CryptoPlan;
use App\Models\CryptoPlanSubscription;
use Auth;
use App\Models\Monitoring;
use App\Libraries\Blockcypher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\BlockChainTxnEmail;
use App\Models\Seo;
use App\Models\Cms;
use App\Models\Partner;
use App\Models\Post;

class HomeController extends Controller
{
	public function __construct() {
        //
	}

    /**
     * Home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['seoData'] = Seo::where('slug','home')->first();
        $data['partner'] = Partner::orderBy('id','desc')->get();

        $data['post'] = Post::take(3)->where('status', 'Publish')
            ->where('publish_at', '<=', Carbon::now())
            ->orderBy('publish_at', 'desc')
            ->get();

    	return view('frontend.home',$data);
    }

    /**
     * Pricing view.
     *
     * @return \Illuminate\Http\Response
     */
    public function pricing()
    {
        $seo = Seo::where('slug','pricing')->first();

        $plans = CryptoPlan::where('is_active','Y')->orderBy('is_free')->get();

        if(auth()->user()){
            $check_free_user = CryptoPlanSubscription::where('user_id',auth()->user()->id)->count();

             }else{
                $check_free_user = 0;
             }

        return view('frontend.pricing', ['check_free_user'=>$check_free_user,'plans' => $plans,'seoData'=>$seo]);
    }

    /**
     * About us view.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutUs()
    {
        $data['seoData'] = Seo::where('slug','about-us')->first();
        $record = Cms::where('slug','about-us')->first();
        
        if(isset($record->description)){
        $data['record'] = json_decode($record->description);
        }

    	return view('frontend.about-us',$data);
    }

    /**
     * Threat Map.
     *
     * @return \Illuminate\Http\Response
     */
    public function threatMap()
    {
        $data['seoData'] = Seo::where('slug','threat-map')->first();
    	return view('frontend.threat-map',$data);
    }

    /**
     * Display Terms And Conditions.
     *
     * @return \Illuminate\Http\Response
     */
    public function privacyPolicy()
    {
        $data['record'] = Cms::where('slug','privacy-policy')->first();
    	return view('frontend.privacy-policy',$data);
    }
    
    /**
     * Display Terms And Conditions.
     *
     * @return \Illuminate\Http\Response
     */
    public function termsOfService()
    {
        $data['record'] = Cms::where('slug','terms-condition')->first();
    	return view('frontend.terms-of-services',$data);
    }
}
