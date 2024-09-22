<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class NewsLetterRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:news_letters',
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
            
        ];
    }
}
