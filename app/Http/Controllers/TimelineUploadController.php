<?php

namespace App\Http\Controllers;

// debug用
use Illuminate\Support\Facades\Log;

// use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Model\Timeline; // さっき作成したモデルファイルを引用

class TimelineUploadController extends Controller
{
    public function index() {
        // up/file_upload.blade.indexなのでup.file_uploadにする必要あり
        return view('up.timeline_upload');
    }

    public function action(Request $request) {
        $request->validate([
            'timeline_file' => 'required' // requiredというのはこれがないとエラーになるという意味？
        ]);
        // dd($request);
        // 一旦アップロードしたパスを読み込む。
        // $requestの中のfileメソッドで'upload_file'という名前を読み込んで、その一時保存Pathを取得。
        $text_path = $request->file('timeline_file')->path();
        // そのパスから全てのファイルコンテンツを取得。
        $content = file_get_contents($text_path);
        $content_json = json_decode($content, true);
        $content_array = $content_json["timelineObjects"];
        // dd($content_array);
        foreach($content_array as $o=>$v) {
            // echo array_key_exists("activitySegment", $v) . "XX";
            // echo $o; 
            // dd($v["activitySegment"]);
            if (array_key_exists("activitySegment", $v)) {
                // echo $o . "<br>";
                // dd($v);
                $date = substr($v["activitySegment"]["duration"]["startTimestamp"],0,10);
                $type = $v["activitySegment"]["activityType"];
                $distance = $v["activitySegment"]["distance"];
                echo $date . " " . $type . " " . $distance . "<br>";

                // データベーステーブルにデータを格納する。
                // Modelの中のTimelineを呼んできてinsertをする。
                Timeline::insert(["date" => $date, "moveType" => $type, "distance" => $distance]);
            }
            // echo dd($v);
            // echo PHP_EOL;
        }
        
        echo "timeline upload success";
        exit;
    }
}