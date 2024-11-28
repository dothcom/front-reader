<?php

namespace Dothnews\FrontReader\Services;

class PostService extends BaseService
{
    public function getLatestNews(array $options = [])
    {
        $url = config('front-reader.api_url').'/posts/';
        return $this->makeRequest($url, $options);
    }

    public function getPostBySlug(string $slug)
    {
        $url = config('front-reader.api_url').'/posts/slug/'.$slug;

        return $this->makeRequest($url);
    }
}
