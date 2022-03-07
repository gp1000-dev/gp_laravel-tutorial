<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDo App</title>
    <!-- javascriptライブラリー「flatpickr 」：デフォルトスタイルシート -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- javascriptライブラリー「flatpickr 」：ブルーテーマの追加スタイルシート -->
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<header>
    <nav class="my-navbar">
        <a class="my-navbar-brand" href="/">ToDo App</a>
    </nav>
</header>
<main>
    <div class="container">
        <div class="row">
            <div class="col col-md-offset-3 col-md-6">
                <nav class="panel panel-default">
                    <div class="panel-heading">タスクを追加する</div>
                    <div class="panel-body">
                        <!-- 入門6：エラーメッセージを表示する のテストコード -->
                        <!-- エラーがある場合はIF文の処理を実行する -->
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <!-- エラーメッセージをループで全て列挙して表示する -->
                            @foreach($errors->all() as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                        </div>
                        @endif
                        <form action="{{ route('tasks.create', ['id' => $folder_id]) }}" method="POST">
                            <!-- セキュリティ対策：@csrf は、CSRFトークンを含んだ input 要素を出力します -->
                            @csrf
                            <div class="form-group">
                                <label for="title">タイトル</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" />
                            </div>
                            <div class="form-group">
                                <label for="due_date">期限</label>
                                <!--入門5：入力値を復元する のテストコード
                                *   old()：セッション値を取得する関数（この場合は入力されたタイトルをセッションとして扱う）
                                -->
                                <input type="text" class="form-control" name="due_date" id="due_date" value="{{ old('due_date') }}" />
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">送信</button>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</main>
<!--
* javascriptライブラリー「flatpickr 」のインポート
* 目的の機能：日付のカレンダー表示からの日付取得
-->
<script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
<!-- javascriptライブラリー「flatpickr 」：日本語化のための追加スクリプト -->
<script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
<script>
    /* flatpickr(指定要素名, オプション) */
    flatpickr(document.getElementById('due_date'), {
        /* 言語設定：日本語を指定 */
        locale: 'ja',
        /* 日付形式：年月日を指定 */
        dateFormat: "Y/m/d",
        /* 開始日設定（選択日付の最小値）：現在日より過去日付を制限するに指定 */
        minDate: new Date()
    });
</script>
</body>
</html>
