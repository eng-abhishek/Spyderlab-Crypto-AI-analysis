<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CryptoSettingRequest extends FormRequest
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
            'crypto_url' => 'required|string|min:6|without_spaces|regex:/^[A-Za-z0-9_-]+$/'
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
            'crypto_url.required' => 'Crypto url should not be blank.',
            'crypto_url.without_spaces' => 'White space not allowed.',
            'crypto_url.alpha_num' => 'Invalid url, allowed only alphabets and numbers only.'
        ];
    }
}
