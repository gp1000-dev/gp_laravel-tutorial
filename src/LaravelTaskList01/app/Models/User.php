<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    // テーブル名を明示的に指定する
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    * ユーザークラスの関係性を辿ってフォルダークラスのリストを取得するユーザー関数
    *
    * @return string
    */
    public function folders()
    {
        // ユーザークラスのタスククラスのリストを取得して返す
        // hasMany()：テーブルの関係性を辿ってインスタンスから紐づく情報を取得する関数
        // hasMany(モデル名, 関連するテーブルが持つ外部キーカラム名, hasManyが定義された外部キーに紐づけられたカラム)
        return $this->hasMany('App\Models\Folder');
    }
}
