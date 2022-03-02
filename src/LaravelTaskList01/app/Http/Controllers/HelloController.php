<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    // hello world page
    public function index()
    {
        // エラーを出す場合
        return view('hello',["something"=>""]);

        // エラーを出さない場合
        // return view('hello',["something"=>"FBK"]);
    }
}
