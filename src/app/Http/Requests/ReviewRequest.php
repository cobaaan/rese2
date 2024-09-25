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
    public function prepareForValidation()
    {
        $this->merge([
            'comment' => preg_replace('/\s+/', ' ', trim($this->comment)),
        ]);
    }
    
    public function rules()
    {
        return [
            'rate' => 'required',
            'comment' => 'required|string|max:400',
            'image_path' => 'required|image|mimes:jpeg,png',
        ];
    }
    
    public function messages()
    {
        return [
            'rate.required' => 'レートを記入してください',
            'comment.required' => 'コメントを記入してください',
            'comment.string' => '文字列で記入してください',
            'comment.max' => '400文字以下で記入してください',
            'image_path.required' => '画像を添付してください',
            'image_path.image' => '画像を添付してください',
            'image_path.mimes' => 'ファイル形式はjpegかpngにしてください',
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
