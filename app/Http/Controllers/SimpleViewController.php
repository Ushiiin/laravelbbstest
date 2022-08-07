<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model\Timeline; // さっき作成したモデルファイルを引用

class SimpleViewController extends Controller
{
    public function index() {
        $move_type_number = array(); // 移動をKeyとしてそれを何回やったか。
        $move_total_distance = array(); // 移動をKeyとしてそれによる距離がいくつか。

        $all_data = Timeline::get();
        // dd($all_data);
        foreach ($all_data as $data) {
            // echo $data;
            $type = $data->moveType;
            $dis = $data->distance; // $disの型は整数。
            // echo gettype($dis);
            // echo $data->id;
            // echo "<br>";
            if (array_key_exists($type,$move_total_distance)){
                $move_type_number[$type] += 1;
                $move_total_distance[$type] += 1;
            } else {
                $move_type_number[$type] = 1;
                $move_total_distance[$type] = $dis;
            }
        }
        // var_dump($move_total_distance);
        // var_dump($move_type_number);
        // echo "XXX <br>";
        // Valueをすべてint -> strにする
        foreach ($move_type_number as $k=>$v) {
            // $move_type_number->$k = (string) $v;
            $v = (string) $v;
            $move_type_number[$k] = $v;
            // echo $v;
            // echo gettype($v);
            // echo gettype($move_type_number[$k]);
        }
        foreach ($move_total_distance as $k=>$v) {
            // $move_total_distance->$k = (string) $v;
            $v = (string) $v;
            $move_total_distance[$k] = $v;
            // echo $v;
            // echo gettype($v);
            // echo gettype($move_total_distance[$k]);
        }
        // var_dump($move_total_distance);
        // echo "<br>";
        // var_dump($move_type_number);
        // return view('up.simple_view');
        return view('up.simple_view', compact('move_type_number','move_total_distance'));
    }
}
