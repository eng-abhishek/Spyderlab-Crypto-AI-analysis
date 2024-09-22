<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class SearchByPhoneRequest extends FormRequest
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
            'country_code' => 'required|exists:countries,code',
            'phone_number' => 'required|numeric|digits:10'
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
            //
        ];
    }

    public function failedValidation(Validator $validator)
    {
        if($this->is('api/*')){
            throw new HttpResponseException(response()->json(['messages' => $validator->errors()], 422));
        }

        throw (new \Illuminate\Validation\ValidationException($validator))
        ->errorBag($this->errorBag)
        ->redirectTo($this->getRedirectUrl());
    }
}
