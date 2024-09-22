<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PartnersRequest extends FormRequest
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
       if(isset($this->partner)){
       
       return [
         'url' => 'required|string|min:3|max:500',
         'image' => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048',
               ];
       
       }else{
       
          return [
         'url' => 'required|string|min:3|max:500',
         'image' => 'required|mimes:jpeg,png,jpg,gif,webp|max:2048',
               ];
     
       }   
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