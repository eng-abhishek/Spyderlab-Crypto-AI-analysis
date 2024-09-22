<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
         'email' => 'required|string|exists:users,email',
         'password' => 'required|string',
         'g-recaptcha-response' => 'required|captcha'
     ];
 }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin',
        ];
    }
}
