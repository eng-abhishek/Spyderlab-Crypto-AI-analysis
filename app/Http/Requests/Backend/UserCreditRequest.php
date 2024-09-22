<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UserCreditRequest extends FormRequest
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
            'plan_id' => 'nullable',
            'credits' => 'required_without:plan_id|numeric|integer|min:1'
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
            'user_id' => 'User',
            'plan_id' => 'Plan'
        ];
    }
}
