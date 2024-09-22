<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class MonitoringRequest extends FormRequest
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
            'user_id' => 'required',
            'token' => 'required',
            'address' => 'required',
            'email_list' => 'required_without_all',
            'description' => 'required|min:20|max:1500',
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
            'email_list' => 'Email',
        ];
    }

    public function messages()
    {
     return [

        'email_list.required_without_all' => 'Select atleast one email',
        
    ];
    }

}
