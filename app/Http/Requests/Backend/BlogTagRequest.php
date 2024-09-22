<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class BlogTagRequest extends FormRequest
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
        if(isset($this->tag)){
        return [
         'name' => 'required|string|min:2|max:200|unique:blog_tags,name,'.$this->tag,
               ];
        }else{
        return [
         'name' => 'required|string|min:2|max:200|unique:blog_tags,name',
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
          'name.required'=>'Please enter tag name',
        ];
    }
}