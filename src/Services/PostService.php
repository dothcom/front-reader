<?php

namespace Dothnews\FrontReader\Services;

use Illuminate\Support\Facades\View;

class PostService extends BaseService
{
    public function getLatestNews(array $options = [])
    {
        $url = config('front-reader.api_url').'/posts/';
        $response = $this->makeRequest($url, $options);

        return $this->paginateResponse($response);
    }

    public function getPostBySlug(string $slug, array $options = [])
    {
        $url = config('front-reader.api_url').'/posts/slug/'.$slug;

        return $this->makeRequest($url, $options);
    }

    /**
     * @param  string  $post_type  - um dos tipos em PostTypeEnum: gallery, podcast, post, recipe, video, webstory
     */
    public function templateByType(string $post_type = 'post'): string
    {
        $dir = 'post.';
        $template = 'detail';

        return $dir.(View::exists($dir.$post_type) ? $post_type : $template);
    }
}
