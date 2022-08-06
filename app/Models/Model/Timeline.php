<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $table = 'timeline'; //ここでTableの名前を定義する必要あり。MyphpadminからuploadというTableを作ったとわかる。
    protected $fillable = ['date','moveType','distance']; // 追記したところ
}
