<?php

namespace Dothnews\FrontReader\Services;

class MenuService extends BaseService
{
    public function getMenu(string $identifier)
    {
        $url = config('front-reader.api_url').'/menus/identifier/'.$identifier;

        return $this->makeRequest($url);
    }
}
