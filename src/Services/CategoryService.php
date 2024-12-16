<?php

namespace Dothnews\FrontReader\Services;

class CategoryService extends BaseService
{
    public function getCategory(string $slug)
    {
        $url = config('front-reader.api_url').'/categories/slug/'.$slug;
        return $this->makeRequest($url);
    }
}
