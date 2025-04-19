<?php

namespace Dothcom\FrontReader\Http\Controllers;

class IndexController extends BaseController
{
    public function index()
    {
        return view('index');
    }
}
