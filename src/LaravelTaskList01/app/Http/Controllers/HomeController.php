<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     *  ホームページ
     *  Show the application dashboard.
     *  ホームページを表示するコントローラー
     *  GET /
     *  @param Folder $folder
     *  @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Folder $folder)
    {
        // ログインユーザーを取得する
        $user = Auth::user();

        // ログインユーザーに紐づくフォルダを一つ取得する
        $folder = $user->folders()->first();

        // まだ一つもフォルダを作っていなければホームページをレスポンスする
        if (is_null($folder)) {
            // ホーム画面のPathを渡した結果を返す
            // view('遷移先のbladeファイル名');
            return view('home');
        }

        // フォルダがあればそのフォルダのフォルダ＆タスク一覧にリダイレクトする
        // indexテンプレートにフォルダーIDを渡した結果を返す
        // view('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }
}
