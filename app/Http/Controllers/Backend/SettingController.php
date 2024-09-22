<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\Backend\SiteSettingRequest;
use App\Http\Requests\Backend\AdminSettingRequest;
use App\Http\Requests\Backend\CryptoSettingRequest;
use JsValidator;

class SettingController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function show($page)
    {
        if(!in_array($page, config('constants.settings'))){
            abort(404);
        }

        $settings = Setting::get();

        $settings_arr = [];
        foreach($settings as $setting){
            $settings_arr[$setting->key] = json_decode($setting->value, true);
        }

        return view('backend.settings.'.$page, ['settings' => $settings_arr]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $page, $key)
    {
        if($key == 'site'){

            //Execute validation
            app(SiteSettingRequest::class);

            $input = $request->only('title', 'meta_title', 'meta_description', 'meta_keywords', 'google_search_tags','activation_popup','kyc_mandatory');
           
            $input['meta_keywords'] = implode(",",collect(json_decode($request->get('meta_keywords'),true))->pluck('value')->toArray());

            $input['activation_popup'] = ($request->get('activation_popup')) ? 'Y' : '';
            $input['kyc_mandatory'] = ($request->get('kyc_mandatory')) ? 'Y' : '';

            $message = 'Site details updated successfully.';
        }elseif($key == 'admin'){
            
            $input = $request->only('admin_url');

            //Execute validation
            app(AdminSettingRequest::class);

            $message = 'Admin url changed successfully.';
       
        }elseif($key == 'crypto'){
            
            $input = $request->only('crypto_url');

            //Execute validation
            app(CryptoSettingRequest::class);

            $message = 'Crypto url changed successfully.';

        
        }else{
            return redirect()->route('backend.settings.view', $page)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }

        Setting::updateOrCreate(['key' => $key], ['value' => json_encode($input)]);

        if($key == 'admin'){
            return redirect('/'.$request->get('admin_url'))->with(['status' => 'success', 'message' => $message]);    
        }

        return redirect()->route('backend.settings.view', $page)->with(['status' => 'success', 'message' => $message]);
    }
}
