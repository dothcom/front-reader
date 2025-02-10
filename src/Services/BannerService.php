<?php

namespace Dothcom\FrontReader\Services;

class BannerService extends BaseService
{
    protected $bannersGroupedByType;

    public function listBanner()
    {
        $options = ['per_page' => 100];
        $url = config('front-reader.api_url'). config('front-reader.api_version').'/banners/';
        $response = $this->tryRequest($url, $options);

        $this->bannersGroupedByType = collect($response->data)->groupBy(function ($banner) {
            return $banner->type->slug;
        });

        return $this->bannersGroupedByType;
    }

    public function getBanner(string $code, $qtd = 1)
    {
        if (is_null($this->bannersGroupedByType)) {
            $this->listBanner();
        }

        $banners = $this->bannersGroupedByType->get($code, collect());
        $selectedBanners = $banners->shuffle()->take($qtd);

        return $selectedBanners->toArray();
    }
}
