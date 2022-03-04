<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    // use HasFactory;

    /**
     * ステータス（状態）定義
     * const：定数
     */
    /* 入門4：状態の名前を表示する のテストコード */
    const STATUS = [
        1 => [ 'label' => '未着手' ],
        2 => [ 'label' => '着手中' ],
        3 => [ 'label' => '完了' ],
    ];

    /**
     * ステータス（状態）ラベルのアクセサメソッド
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        // ステータス（状態）カラムの値を取得する
        $status = $this->attributes['status'];

        // STATUSに定義されていない場合
        if (!isset(self::STATUS[$status])) {
            // 空文字を返す
            return '';
        }
        // STATUSの値（['label']）を返す
        return self::STATUS[$status]['label'];
    }
}
