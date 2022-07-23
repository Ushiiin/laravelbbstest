<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bbs extends Model
{
    protected $fillable = ['name','comment']; // 追記したところ
}
