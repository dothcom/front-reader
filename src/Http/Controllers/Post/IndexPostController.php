<?php

namespace Dothcom\FrontReader\Http\Controllers\Post;

use Illuminate\Routing\Controller;

class IndexPostController extends Controller
{
    public function index()
    {
        return view('post.index');
    }
}
