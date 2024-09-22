<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends FormRequest
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
        if(isset($this->plan)){
            $rules = [
                'name' => 'required|string|max:100|alpha_spaces|unique:plans,name,'.$this->plan,
                'slug' => 'required|string|max:100|unique:plans,slug,'.$this->plan,
                'credits' => 'required|numeric|integer|min:1',
                'price' => 'required|numeric|integer|min:1'
            ];
        }else{
            $rules = [
                'name' => 'required|string|max:100|alpha_spaces|unique:plans',
                'slug' => 'required|string|max:100|unique:plans',
                'credits' => 'required|numeric|integer|min:1',
                'price' => 'required|numeric|integer|min:1'
            ];
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
            'department_id' => 'Department'
        ];
    }
}
