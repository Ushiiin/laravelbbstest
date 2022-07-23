<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 
class SampleController extends Controller
{
    public function showPage(){
        return view('sample');
    }
}