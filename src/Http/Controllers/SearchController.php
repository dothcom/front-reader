<?php

namespace Dothcom\FrontReader\Http\Controllers;

class SearchController extends BaseController
{
    public function index()
    {
        return view('search.results');
    }
}
