<?php

namespace Dothcom\FrontReader\Http\Controllers\Tag;

use Dothcom\FrontReader\Http\Controllers\BaseController;

class IndexTagController extends BaseController
{
    public function index()
    {
        return response()->view('tag.index');
    }
}
