<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Up extends Model
{
    protected $table = 'upload'; //ここでTableの名前を定義する必要あり。MyphpadminからuploadというTableを作ったとわかる。
    protected $fillable = ['content']; // 追記したところ
}
