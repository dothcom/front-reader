<?php

namespace Dothcom\FrontReader\Http\Controllers\Post;

use Dothcom\FrontReader\Http\Controllers\BaseController;
use Dothcom\FrontReader\Services\PostService;

class DetailPostController extends BaseController
{
    public function index(string $permalink)
    {
        $permalink = '/' . ltrim($permalink, '/');

        $postService = new PostService();
        $post = $postService->getPostBySlug($slug, [
            '_embed' => 'featuredmedia,users,pages,tags,medias',
        ]);

        if (! $post) {
            return abort(404);
        }

        if ($post->data->permalink !== $permalink) {
            return abort(404);
        }


        $template = $postService->templateByType($post->data->post_type);

        return view($template, ['post' => $post->data]);
    }

    /**
     * Extracts the slug from a permalink.
     *
     * @param  string  $permalink  The permalink to extract the slug from.
     * @return string The extracted slug.
     */
    // Example: /noticia/2025/06/23/voluptas-dolor-labore-molestiae-ex-suscipit-accusamus.html
    // This method assumes the slug is the last part of the permalink,
    // excluding the file extension (.html).
    // returns: 'voluptas-dolor-labore-molestiae-ex-suscipit-accusamus'
    private function slugFromPermalink(string $permalink): string
    {
        $parts = explode('/', $permalink);
        $slug = end($parts);

        return preg_replace('/\.html$/', '', $slug);
    }
}
