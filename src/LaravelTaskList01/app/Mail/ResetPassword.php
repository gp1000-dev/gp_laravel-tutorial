<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    /**
     * Create a new message instance.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     * PW再設定メールのテンプレートを表示するメソッド
     * @return $this
     */
    public function build()
    {
        // password-resetテンプレートに結果を返す
        // subject('メールのタイトル名')
        // view('遷移先のbladeファイル名');
        return $this->subject('パスワード再設定')->view('mail.password-reset');
    }
}
