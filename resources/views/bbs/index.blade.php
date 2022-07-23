<!DOCTYPE HTML>
<html>
<head>
    <title>掲示板</title>
</head>
<body>

<h1>データ表示・送信</h1>

<!-- エラーメッセージエリア -->
<!-- バリデーションエラーの場合は勝手に$errorという変数が投げられる。 -->
@if ($errors->any())
    <h2>エラーメッセージ</h2>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<!-- 直前投稿エリア -->
<!-- issetは変数が定義されていた時のみ読み込まれる。 -->
<!-- @isset($name, $comment)
<h2>{{ $name }}さんの直前の投稿</h2>
{{ $comment }}
<br><hr>
@endisset -->

@isset($bbs)
@foreach ($bbs as $d)
<h2>{{ $d->name }}さんの投稿</h2>
    {{ $d->comment }}
    <br><hr>
@endforeach
@endisset


<!-- フォームエリア -->
<h2>フォーム</h2>
<form action="/bbs" method="POST">
    名前:<br>
    <input name="name">
    <br>
    コメント:<br>
    <textarea name="comment" rows="4" cols="40"></textarea>
    <br>
    {{ csrf_field() }}
    <button class="btn btn-success"> 送信 </button>
</form>

</body>
</html>