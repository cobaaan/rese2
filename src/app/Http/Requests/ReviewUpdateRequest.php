<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewUpdateRequest extends FormRequest
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
            'rate' => 'required',
            'comment' => 'required | string | max:400',
        ];
    }
    
    public function messages() {
        return [
            'rate.required' => 'レートを記入してください',
            'comment.required' => 'コメントを記入してください',
            'comment.string' => '文字列で記入してください',
            'comment.max' => '400文字以下で記入してください',
        ];
    }
}
