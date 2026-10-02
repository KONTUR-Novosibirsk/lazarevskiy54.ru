<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index(): \Illuminate\Http\Response
    {
        return response()->view('index');
    }
}
