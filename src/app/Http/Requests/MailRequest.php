<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailRequest extends FormRequest
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
            'subject' => 'required | string | max:30',
            'body' => 'required | string',
        ];
    }
    
    public function messages() {
        return [
            'subject.required' => '件名を入力してください',
            'subject.string' => '文字列で入力してください',
            'subject.max' => '30字以下で入力してください',
            'body.required' => 'メッセージを入力してください',
            'body.string' => '文字列で入力してください',
        ];
    }
    
    protected function failedValidation($validator)
    {
        $requests = $this->all();
        
        $this->session()->flash('errors', $validator->errors());
        
        $this->redirect = route('mail_form', $requests);
        
        parent::failedValidation($validator);
    }
}
