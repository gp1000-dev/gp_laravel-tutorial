<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    // hello world page
    public function index()
    {
        return view('hello');
    }
}
