<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class ContactUsRequest extends FormRequest
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
        $rules = [
            'query_type' => 'required',
            'name' => 'required|string|max:255|alpha_spaces',
            'email_id' => 'required|string|email|max:255',
            //'phone_no' => 'required|numeric|digits:10',
            'query' => 'required|min:25|max:1000',
            'g-recaptcha-response' => 'required|captcha'
        ];

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
          
        ];
    }


    public function messages()
    {
        return [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin',
        ];
    }
}
