<?php

namespace Dothcom\FrontReader\Services;

class MediaService extends BaseService
{
    public function getMedia(string $uuid, array $options = [])
    {
        $url = config('front-reader.api_url'). config('front-reader.api_version').'/medias/'.$uuid;

        return $this->tryRequest($url, $options);
    }
}
