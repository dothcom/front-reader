<?php

namespace Dothnews\FrontReader\Services;

class BannerService extends BaseService
{
    protected $bannersGroupedByType;

    public function listBanner()
    {
        $options = ['per_page' => 100];
        $url = config('front-reader.api_url').'/banners/';
        $response = $this->makeRequest($url, $options);

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

        $displayedBannerIds = session()->get('bannerExibido.'.$code, []);

        $bannersToShow = $banners->whereNotIn('id', $displayedBannerIds);

        if ($bannersToShow->isEmpty()) {
            session()->put('bannerExibido.'.$code, []);
            $bannersToShow = $banners;
        }

        $selectedBanners = $bannersToShow->shuffle()->take($qtd);

        session()->put('bannerExibido.'.$code, array_merge($displayedBannerIds, $selectedBanners->pluck('id')->toArray()));

        return $selectedBanners->toArray();
    }
}
