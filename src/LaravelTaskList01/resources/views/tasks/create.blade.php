<!--
*   extends：親ビューを継承する（読み込む）
*   親ビュー名：layout を指定
-->
@extends('layout')

<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：styles を指定
*   用途：javascriptライブラリー「flatpickr 」のスタイルシートを指定
-->
@section('styles')
    @include('share.flatpickr.styles')
@endsection

<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：content を指定
*   用途：タスクを追加するHTMLを表示する
-->
@section('content')
    <div class="container">
        <div class="row">
        <div class="col col-md-offset-3 col-md-6">
            <nav class="panel panel-default">
                <div class="panel-heading">タスクを追加する</div>
                <div class="panel-body">
                    <!-- エラーメッセージを表示する -->
                    <!-- エラーがある場合はIF文の処理を実行する -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                <!-- エラーメッセージをループで全て列挙して表示する -->
                                @foreach($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('tasks.create', ['folder' => $folder_id]) }}" method="POST">
                    <!-- セキュリティ対策：@csrf は、CSRFトークンを含んだ input 要素を出力します -->
                    @csrf
                        <div class="form-group">
                            <label for="title">タイトル</label>
                            <!--入力値を復元する
                            *   old：セッション値を取得する関数（この場合は入力されたタイトルをセッションとして扱う）
                            -->
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" />
                        </div>
                        <div class="form-group">
                            <label for="due_date">期限</label>
                            <!--入力値を復元する
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
@endsection

<!--
*   section：子ビューで定義したデータを表示する
*   セクション名：scripts を指定
*   目的：flatpickr によるカレンダー形式による日付選択
*   用途：javascriptライブラリー「flatpickr 」のインポートと日本語化並びにcodeの記述
-->
@section('scripts')
    @include('share.flatpickr.scripts')
@endsection
