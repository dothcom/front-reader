<?php

namespace Dothnews\FrontReader\Services;

use Illuminate\Support\Facades\Http;

class PostService
{
    public function getLatestNews(int $limit = 10)
    {
        $response = Http::accept('application/json')
                        ->withToken(config('front-reader.api_key'))
                        ->get(config('front-reader.api_url').'/api/posts/?per_page='.$limit);

        if ($response->status() == 404) {
            throw new \Exception('Posts not found');
        }

        return $response->object() ;
    }
}
