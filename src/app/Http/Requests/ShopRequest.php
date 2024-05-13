<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'name' => 'required | string | max:20',
            'area' => 'required | string | max:10',
            'genre' => 'required | string | max:10',
            'description' => 'required | string | max:1000',
            'image' => 'required | image | mimes:jpeg,png,jpg,gif | max:2048',
        ];
    }
    
    public function messages() {
        return [
            'name.required' => '名前を入力してください',
            'name.string' => '文字列で入力してください',
            'name.max' => '20文字以下で入力してください',
            'area.required' => 'エリアを入力してください',
            'area.string' => '文字列で入力してください',
            'area.max' => '10文字以下で入力してください',
            'genre.required' => 'ジャンルを入力してください',
            'genre.string' => '文字列で入力してください',
            'genre.max' => '10文字以下で入力してください',
            'description.required' => '詳細を入力してください',
            'description.string' => '文字列で入力してください',
            'description.max' => '1000文字以下で入力してください',
            'image.required' => '画像を入力してください',
            'image.image' => '画像形式で入力してください',
            'image.mimes' => 'jpeg形式、png形式、jpg形式、gif形式で入力してください',
            'image.max' => '2MB以内のファイルを入力してください',
        ];
    }
    
    // バリデーションエラーが発生したときのリダイレクト先を指定
    protected function failedValidation($validator)
    {
        $requests = $this->all();
        // バリデーションエラーメッセージを取得してセッションにセット
        $this->session()->flash('errors', $validator->errors());
        
        // リダイレクト先のURLにパラメータを付けてリダイレクト
        $this->redirect = route('shop_manager', $requests);
        
        // 親クラスのfailedValidationメソッドを呼び出してバリデーションエラーの処理を続行
        parent::failedValidation($validator);
    }
}
