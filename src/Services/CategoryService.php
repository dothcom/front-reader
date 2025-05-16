<?php

namespace Dothcom\FrontReader\Services;

class CategoryService extends BaseService
{
    public function getCategory(string $slug)
    {
        $url = '/categories/slug/'.$slug;

        return $this->tryRequest($url);
    }
}
