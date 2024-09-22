<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $user = auth()->user();
        
        $rules = [
            'name' => 'required|string|max:255',
            //'mobile' => 'nullable|numeric|digits:10|unique:users,mobile,'.$user->id,
            //'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
