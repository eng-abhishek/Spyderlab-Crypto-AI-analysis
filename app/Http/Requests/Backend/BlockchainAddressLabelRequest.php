<?php
namespace App\Http\Requests\Backend;
use Illuminate\Foundation\Http\FormRequest;

class BlockchainAddressLabelRequest extends FormRequest
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
        return [
           'address' => 'required',
           'currency' => 'required',
           'labels' => 'required'
       ];
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
