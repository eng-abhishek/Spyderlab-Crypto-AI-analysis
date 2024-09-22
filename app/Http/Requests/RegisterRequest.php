<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            //'name' => 'required|string|max:255|alpha_spaces',
            'username' => 'required|string|alpha_num|min:3|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'g-recaptcha-response' => 'required|captcha',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
    * Get custom attributes for validator errors.
    *
    * @return array
    */
    public function attributes()
    {
        return [
            'mobile' => 'phone number'
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
            'name.required' => 'Please enter your name!',
            'username.required' => 'Please enter your username!',
            'email.required' => 'Please enter your email!',
            'password.required' => 'Please enter your password!',
            'password.confirmed' => 'The confirm password does not match.',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin',
        ];
    }
}
