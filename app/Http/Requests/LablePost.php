<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LablePost extends FormRequest
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
            'title' => 'required|max:50',
            'contents' => 'max:255',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标签名为必填项',
            'title.max'  => '标签名超过最大长度',
            'content.max' => '内容介绍超过最大长度'
        ];
    }
}
