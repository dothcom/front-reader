<?php

namespace Dothnews\FrontReader\Services;

use Illuminate\Support\Facades\Http;

class MenuService
{
    public function getMenu(string $identifier)
    {
        $response = Http::accept('application/json')
                    ->withToken(config('front-reader.api_key'))
                    ->get(config('front-reader.api_url').'/api/menus/identifier/'.$identifier);

        if ($response->status() == 404) {
            throw new \Exception('Menu with identifier '.$identifier.' not found');
        }

        return $response->object() ;
    }
}
