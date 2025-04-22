<?php

namespace Dothcom\FrontReader\Services;

class MediaService extends BaseService
{
    public function getMedia(string $uuid, array $options = [])
    {
        $endpoint = '/medias/'.$uuid;

        return $this->tryRequest($endpoint, $options);
    }
}
