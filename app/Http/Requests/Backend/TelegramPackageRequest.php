<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class TelegramPackageRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'no_of_request' => 'required|numeric',
            'price'=>'required|numeric',
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
            //
        ];
    }
}
