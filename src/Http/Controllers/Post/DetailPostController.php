<?php

namespace DothNews\FrontReader\Http\Controllers\Post;

use DothNews\FrontReader\Http\Controllers\BaseController;

class DetailPostController extends BaseController
{
    public function index()
    {
        return view('post.detail');
    }
}
