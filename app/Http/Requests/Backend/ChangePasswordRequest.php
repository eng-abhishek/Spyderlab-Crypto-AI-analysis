<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|match_current_password',
            'password' => 'required|min:8',
			'password_confirmation' => 'required_with:password|same:password',                        
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [			
            'current_password'=>'Current password',
            'password'=>'New Password',
			'password_confirmation'=>'Confirm password',
        ];
    }
}
