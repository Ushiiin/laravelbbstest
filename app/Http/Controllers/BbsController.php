<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model\Bbs; // さっき作成したモデルファイルを引用

class BbsController extends Controller
{
    // Indexページの表示
    public function index() {
        return view('bsb.index');
    }

    // 投稿された内容を表示するページ
    public function create(Request $request) {

        // バリデーションチェック
        $request->validate([
            'name' => 'required|max:10', // 名前は必須かつ10文字以下
            'comment' => 'required|min:5|max:140',
        ]);

        // 投稿内容の受け取って変数に入れる
        // nameという名前とcommentという名前がついている。
        $name = $request->input('name');
        $comment = $request->input('comment');

        // データベーステーブルbbsにデータを格納する。
        Bbs::insert(["name" => $name, "comment" => $comment]);

        // データベーステーブルbbsに存在するデータを取得し、bbs.indexへ渡す
        $bbs = Bbs::all();
        return view('bsb.index', ["bbs" => $bbs]); 

        // 変数をビューに渡す
        return view('bsb.index')->with([
            "name" => $name,
            "comment"  => $comment,
        ]);
    }

}