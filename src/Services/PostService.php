<?php

namespace Dothnews\FrontReader\Services;

class PostService extends BaseService
{
    public function getLatestNews(int $limit = 10)
    {
        $url = config('front-reader.api_url').'/posts/';
        $options = ['status' => 'published', 'per_page' => $limit];
        return $this->makeRequest($url, $options);
    }

    public function getPostBySlug(string $slug)
    {
        $url = config('front-reader.api_url').'/posts/slug/'.$slug;

        return $this->makeRequest($url);
    }
}
