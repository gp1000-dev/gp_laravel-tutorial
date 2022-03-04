<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FolderController extends Controller
{
    // 入門5：コントローラー のテストコード
    /**
     *  Folder新規作成画面を表示するコントローラー
     *  @return string
     */
    public function showCreateForm()
    {
        // createテンプレートにFolder新規作成画面のPathを渡した結果を返す
        // view('遷移先のbladeファイル名');
        return view('folders/create');
    }
}
