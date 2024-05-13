<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReserveRequest extends FormRequest
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
            'date' => 'required | date',
            'time' => 'required',
            'number' => 'required | integer',
        ];
    }
    
    public function messages() {
        return [
            'date.required' => '日付を入力してください',
            'date.date' => '日付を入力してください',
            'time.required' => '時間を入力してください',
            'number.required' => '人数を入力してください',
            'number.integer' => '数字を入力してください',
        ];
    }
    
    // バリデーションエラーが発生したときのリダイレクト先を指定
    protected function failedValidation($validator)
    {
        $requests = $this->all();
        //dd($requests['page']);
        // バリデーションエラーメッセージを取得してセッションにセット
        $this->session()->flash('errors', $validator->errors());
        
        // リダイレクト先のURLにパラメータを付けてリダイレクト
        if($requests['page'] === 'shop_detail'){
            $this->redirect = route('shop_detail', $requests);
        }
        else if($requests['page'] === 'change_reserve') {
            $this->redirect = route('change_reserve', $requests);
        }
        
        // 親クラスのfailedValidationメソッドを呼び出してバリデーションエラーの処理を続行
        parent::failedValidation($validator);
    }
}
