<?php
namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class WalletAddressRequest extends FormRequest
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
        if(isset($this->wallet_address)){
            $rules = [
                'name' => 'required|string|max:255',
                'token' => 'required|string|max:50',
                'address' => 'required|string|max:500',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:ratio=1/1|max:2048'
            ];
        }else{
            $rules = [
                'name' => 'required|string|max:255',
                'token' => 'required|string|max:50',
                'address' => 'required|string|max:500',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:ratio=1/1|max:2048'
            ];
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
}
