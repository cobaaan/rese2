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
    
    // バリデーションエラーが発生したときのリダイレクト先を指定
    protected function failedValidation($validator)
    {
        $requests = $this->all();
        // バリデーションエラーメッセージを取得してセッションにセット
        $this->session()->flash('errors', $validator->errors());
        
        // リダイレクト先のURLにパラメータを付けてリダイレクト
        $this->redirect = route('review', $requests);
        
        // 親クラスのfailedValidationメソッドを呼び出してバリデーションエラーの処理を続行
        parent::failedValidation($validator);
    }
}
