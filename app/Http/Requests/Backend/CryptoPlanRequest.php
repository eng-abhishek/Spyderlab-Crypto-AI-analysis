<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CryptoPlanRequest extends FormRequest
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
        if(isset($this->crypto_plan)){
            $rules = [
                
                'name' => 'required|string|max:100|alpha_spaces|unique:crypto_plans,name,'.$this->crypto_plan,
                'slug' => 'required|string|max:100|unique:crypto_plans,slug,'.$this->crypto_plan,
                'description' => 'required',
                'feature' => 'array|min:1',
                'feature.*.feature' => 'required|max:255',
                'monthly_price' => 'sometimes|required|numeric|min:1',
                // 'yearly_price' => 'sometimes|required|numeric|integer|min:1',
                'duration' => 'sometimes|required|numeric|integer|min:1',
            ];
        }else{
            $rules = [
                'name' => 'required|string|max:100|alpha_spaces|unique:crypto_plans',
                'slug' => 'required|string|max:100|unique:crypto_plans',
                'description' => 'required',
                'feature' => 'array|min:1',
                'feature.*.feature' => 'required|max:255',
                'monthly_price' => 'sometimes|required|numeric|min:1',
                // 'yearly_price' => 'sometimes|required|numeric|integer|min:1',
                'duration' => 'sometimes|required|numeric|integer|min:1',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'feature.array' => 'Please fill feature',
            'feature.*.feature.required' => 'Please fill feature',
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
            'department_id' => 'Department'
        ];
    }
}
