<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class BlogCommentRequest extends FormRequest
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
            'name' => 'required|string|max:255|alpha_spaces',
            'email' => 'required|string|email|max:255',
            'comment' => 'required|string|min:25|max:2500',
            'g-recaptcha-response' => 'required|captcha'
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
            'g-recaptcha-response.required' => 'Please verify that you are not a robot',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin',
        ];
    }
}
