<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        if(isset($this->post)){
            $rules = [
                'title' => 'required|string|max:255|unique:posts,title,'.$this->post,
                'slug' => 'required|string|max:255|unique:posts,slug,'.$this->post,
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048|dimensions:width=1280,height=720',
                'image_alt' => 'nullable|string|max:100',
                'image_title' => 'nullable|string|max:100',
                'content' => 'required',
                'status' => 'required',
                'publish_at' => 'required_if:status,Publish',
                'meta_title' => 'required|string|max:80',
                'meta_description' => 'required|string|max:200',
                'blog_category_id' => 'required',
                'blog_tag_id' => 'required',
                'is_faq' => 'sometimes',
                'faq' => 'array|min:1',
                'faq.*.key' => 'required|max:500',
                'faq.*.description' => 'required|max:2000',
            ];

        }else{
            $rules = [
                'title' => 'required|string|max:255|unique:posts',
                'slug' => 'required|string|max:255|unique:posts',
                'image' => 'required|mimes:jpeg,png,jpg,gif,webp|max:2048|dimensions:width=1280,height=720',
                'image_alt' => 'nullable|string|max:100',
                'image_title' => 'nullable|string|max:100',
                'content' => 'required',
                'status' => 'required',
                'publish_at' => 'required_if:status,Publish',
                'meta_title' => 'required|string|max:80',
                'meta_description' => 'required|string|max:200',
                'blog_category_id' => 'required',
                'blog_tag_id' => 'required',
                'is_faq' => 'sometimes',
                'faq' => 'array|min:1',
                'faq.*.key' => 'required|max:500',
                'faq.*.description' => 'required|max:2000',
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
            'image' => 'Featured Image',
            'faq.array' => 'Please fill other faq value',
            'faq.*.key.required' => 'Please fill other faq title',
            'faq.*.description.required' => 'Please fill faq description',
        ];
    }
}
