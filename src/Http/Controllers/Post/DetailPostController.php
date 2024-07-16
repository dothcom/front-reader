<?php

namespace DothNews\FrontReader\Http\Controllers\Post;

use Illuminate\Routing\Controller;

class DetailPostController extends Controller
{
    public function index()
    {
        return view('post.detail');
    }
}
