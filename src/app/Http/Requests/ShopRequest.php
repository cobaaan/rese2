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
            'name' => 'required|string|max:20',
            'area' => 'required|string|max:10',
            'genre' => 'required|string|max:10',
            'description' => 'required|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg',
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
            'description.required' => '店舗説明を入力してください',
            'description.string' => '文字列で入力してください',
            'description.max' => '1000文字以下で入力してください',
            'image.required' => '画像を選択してください',
            'image.image' => '画像形式で入力してください',
            'image.mimes' => 'jpeg形式、png形式、jpg形式で入力してください',
        ];
    }
    
    protected function failedValidation($validator)
    {
        $requests = $this->all();
        $this->session()->flash('errors', $validator->errors());
        
        $this->redirect = route('shop_manager', $requests);
        
        parent::failedValidation($validator);
    }
}
