<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255|alpha_spaces',
            'username' => 'required|string|alpha_num|min:3|max:255|unique:users,username,'.$user->id,
           //'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
          //'mobile' => 'required|numeric|digits:10|unique:users,mobile,'.$user->id,
        ];

        // if($user->isWeb3User()){
        //     $rules['password'] = 'required|string|min:8|confirmed';
        // }

        if(empty($user->password)){
            $rules['password'] = 'required|string|min:8|confirmed';
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
            'mobile.required' => 'Please enter your phone number!',
        ];
    }
}
