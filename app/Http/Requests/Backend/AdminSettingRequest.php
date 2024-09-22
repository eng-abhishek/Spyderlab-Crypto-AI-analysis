<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class AdminSettingRequest extends FormRequest
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
            'admin_url' => 'required|string|min:6|without_spaces|alpha_num'
        ];

        return $rules;

    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages() {
        return [            
            'admin_url.required' => 'Admin url should not be blank.',
            'admin_url.without_spaces' => 'White space not allowed.',
            'admin_url.alpha_num' => 'Invalid url, allowed only alphabets and numbers only.'
        ];
    }
}
