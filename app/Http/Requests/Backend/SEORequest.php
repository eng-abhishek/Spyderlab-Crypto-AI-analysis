<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SEORequest extends FormRequest
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
             'title' => 'string|min:4|max:250',
             'meta_title' => 'string|min:4|max:500',
             'description' => 'string|min:100|max:2000',
             'keyword' => 'string|min:4|max:500',
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
            'image' => 'Featured Image'
        ];
    }
}
