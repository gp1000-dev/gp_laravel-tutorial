<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    // テーブル名を明示的に指定する
    protected $table = 'folders';

    // 入門4：モデルクラスにおけるリレーション のテストコード
    /*
    * フォルダクラスの関係性を辿ってタスククラスのリストを取得するユーザー関数
    *
    * @return string
    */
    public function tasks()
    {
        // フォルダクラスのタスククラスのリストを取得して返す
        // hasMany()：テーブルの関係性を辿ってインスタンスから紐づく情報を取得する関数
        // hasMany(モデル名, 関連するテーブルが持つ外部キーカラム名, hasManyが定義された外部キーに紐づけられたカラム)
        return $this->hasMany('App\Models\Task');
    }
}
