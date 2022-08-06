<?php

namespace App\Http\Controllers;

// debug用
use Illuminate\Support\Facades\Log;

// use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Model\Up; // さっき作成したモデルファイルを引用

class FileUploadController extends Controller
{
    public function index() {
        // up/file_upload.blade.indexなのでup.file_uploadにする必要あり
        return view('up.file_upload');
    }

    public function action(Request $request) {
        $request->validate([
            'upload_file' => 'required' // requiredというのはこれがないとエラーになるという意味？
        ]);
        // dd($request);
        // 一旦アップロードしたパスを読み込む。
        // $requestの中のfileメソッドで'upload_file'という名前を読み込んで、その一時保存Pathを取得。
        $text_path = $request->file('upload_file')->path();
        // そのパスから全てのファイルコンテンツを取得。
        $content = file_get_contents($text_path);
        // dd($content);

        // storage/app/upfiles配下にアップロード
        // $request->upload_file->store('upfiles');
        // var_dump($request->upload_file);

        // データベーステーブルuploadにデータを格納する。
        // Modelの中のUpを呼んできてinsertをする。
        Up::insert(["content" => $content]);

        echo "upload success";
        exit;
    }
}