<!--
*   extends()：親ビューを継承する（読み込む）
*   親ビュー名：layout を指定
-->
@extends('layout')

<!--
*   section()：子ビューにsectionでデータを定義する
*   セクション名：content を指定
*   用途：パスワード再設定メール送信ページを表示する
-->
@section('content')
<div class="container">
    <div class="row">
        <div class="col col-md-offset-3 col-md-6">
            <nav class="panel panel-default">
                <div class="panel-heading">パスワード再発行</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('password.email') }}" method="POST">
                        <!-- セキュリティ対策：@csrf は、CSRFトークンを含んだ input 要素を出力します -->
                        @csrf
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <input type="text" class="form-control" id="email" name="email" />
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">再発行リンクを送る</button>
                        </div>
                    </form>
                </div>
            </nav>
        </div>
    </div>
</div>
@endsection
