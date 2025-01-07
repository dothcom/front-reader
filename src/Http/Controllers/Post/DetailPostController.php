<?php

namespace DothNews\FrontReader\Http\Controllers\Post;

use DothNews\FrontReader\Http\Controllers\BaseController;
use Dothnews\FrontReader\Services\PostService;
use Illuminate\Support\Facades\View;

class DetailPostController extends BaseController
{
    public function index($slug = 'titulo-do-post')
    {
        $postService = new PostService();

        $post = $postService->getPostBySlug($slug, [
            '_embed' => 'featuredmedia,users,categories,tags,medias',
        ]);

        if (! isset($post->data->id)) {
            abort(404);
        }

        $template = $postService->templateByType($post->data->post_type);

        if (! View::exists($template)) {
            abort(404);
        }

        return view($template, ['post' => $post->data]);
    }
}
