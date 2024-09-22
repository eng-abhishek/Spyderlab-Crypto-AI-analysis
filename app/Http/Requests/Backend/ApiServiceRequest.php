<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ApiServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $api_service = \App\Models\ApiService::find($this->api_service);

        $rules = [];
        if($api_service->slug == 'truecaller'){
            $rules = [
                'credentials.authkey' => 'required|mimes:json|max:2048',
            ];
        }elseif($api_service->slug == 'numverify'){
            $rules = [
                'credentials.apikey' => 'required',
            ];
        }elseif($api_service->slug == 'facebook'){
            $rules = [
                'credentials.e_auth' => 'required',
                'credentials.e_auth_v' => 'required',
                'credentials.e_auth_c' => 'required|numeric|integer',
                'credentials.e_auth_k' => 'required',
            ];
        }elseif($api_service->slug == 'twitter'){
            $rules = [
                'credentials.authorization' => 'required',
            ];
        }elseif($api_service->slug == 'have-i-been-pwned'){
            $rules = [
                'credentials.apikey' => 'required',
            ];
        }elseif($api_service->slug == 'whatsapp'){
            $rules = [
                'credentials.wa_instance' => 'required',
                'credentials.apikey' => 'required',
            ];
        }elseif($api_service->slug == 'telegram'){
            $rules = [
                'credentials.api_id' => 'required',
                'credentials.api_hash' => 'required',
                'credentials.phone_number' => 'required',
            ];
        }elseif($api_service->slug == 'chainsight'){
            $rules = [
                'credentials.apikey' => 'required',
            ];
        }

        return $rules;
    }

    /**
 * Get custom attributes for validator errors.
 *
 * @return array
 */
    public function attributes()
    {
        return [
            'credentials.authkey' => 'Auth Key',
            'credentials.apikey' => 'Api Key',
            'credentials.e_auth' => 'E-Auth',
            'credentials.e_auth_v' => 'E-Auth-V',
            'credentials.e_auth_c' => 'E-Auth-C',
            'credentials.e_auth_k' => 'E-Auth-K',
            'credentials.authorization' => 'Authorization',
            'credentials.api_id' => 'Api ID',
            'credentials.api_hash' => 'Api Hash',
            'credentials.phone_number' => 'Phone Number',
        ];
    }
}
