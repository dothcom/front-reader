<?php

namespace Dothnews\FrontReader\Services;

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
}
