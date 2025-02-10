<?php

namespace Dothcom\FrontReader\Services;

class CategoryService extends BaseService
{
    public function getCategory(string $slug)
    {
        $url = config('front-reader.api_url'). config('front-reader.api_version').'/categories/slug/'.$slug;

        return $this->tryRequest($url);
    }
}
