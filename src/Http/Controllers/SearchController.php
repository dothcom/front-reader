<?php

namespace Dothcom\FrontReader\Http\Controllers;

use Dothcom\FrontReader\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchController extends BaseController
{
    public function index(Request $request, PostService $postService)
    {
        $options = [
            'per_page' => 10,
            '_embed' => 'featuredmedia,categories',
            'q' => $request->query('q'),
            'page' => $request->get('page', 1),
        ];

        $posts = $postService->getLatestNews($options);
        $status = Response::HTTP_OK;

        if (isset($posts->message) || $posts->isEmpty()) {
            $posts = [];
            $status = Response::HTTP_NOT_FOUND;
        }

        return response()->view('search.results', compact('posts'), $status);
    }
}
