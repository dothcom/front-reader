<?php

namespace Dothcom\FrontReader\Services;

use Illuminate\Support\Str;

class WeatherService extends DataFetcherService
{
    public function getWeather($cidade, $ttl = 2)
    {
        $slug = preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $cidade) === 1 ? $cidade : Str::slug($cidade);
        $url = 'https://dn-commons.dothnews.com.br/previsao-do-tempo/'.$slug.'.json';

        return $this->download($url, 'json/previsao_tempo/'.$slug.'.json', $ttl);
    }
}
