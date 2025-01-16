<?php

namespace Dothcom\FrontReader\Services;

class MediaService extends BaseService
{
    public function getMedia(string $uuid, array $options = [])
    {
        $url = config('front-reader.api_url').'/medias/'.$uuid;

        return $this->makeRequest($url, $options);
    }
}
