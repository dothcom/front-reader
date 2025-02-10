<?php

namespace Dothcom\FrontReader\Services;

class SettingsService extends BaseService
{
    protected $settings = [];

    public function __construct()
    {
        $this->settings = $this->getSettings();
    }

    public function getSettings()
    {
        $url = config('front-reader.api_url'). config('front-reader.api_version').'/settings/';
        $response = $this->tryRequest($url);

        $data = is_object($response) ? (array) $response : $response;

        return $data['data'] ?? [];
    }

    public function getConfig($name)
    {
        $config = collect($this->settings)->firstWhere('name', $name);

        return $config ? $config->payload : '';
    }
}
