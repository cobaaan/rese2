<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'comment' => 'required | string | max:1000',
        ];
    }
    
    public function messages() {
        return [
            'comment.required' => 'コメントを記入してください',
            'comment.string' => '文字列で記入してください',
            'comment.max' => '1000文字以下で記入してください',
        ];
    }
    
    protected function failedValidation($validator)
    {
        $requests = $this->all();
        
        $this->session()->flash('errors', $validator->errors());
        
        $this->redirect = route('review', $requests);
        
        parent::failedValidation($validator);
    }
}
