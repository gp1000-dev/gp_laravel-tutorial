<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFolder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * リクエストの内容に基づいた権限チェックを行う関数
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
        // 返り値にtrueを指定する（リクエストを受け付ける）
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * バリデーションルールを定義する関数
     *
     * @return array
     */
    public function rules()
    {
        return [
            // タイトルの入力欄を入力必須の最大文字数20文字に定義する
            'title' => 'required|max:20',
        ];
    }

    /**
     * リクエストのnameなどの値を再定義する関数
     *
     * @return string
     */
    public function attributes()
    {
        return [
            'title' => 'フォルダ名',
        ];
    }
}
