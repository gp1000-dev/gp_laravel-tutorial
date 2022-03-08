<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     *  ホームページを表示するコントローラー
     *  GET /
     *  @return \Illuminate\View\View
     */
    public function index()
    {
        // ホーム画面のPathを渡した結果を返す
        // view('遷移先のbladeファイル名');
        return view('home');
    }
}
