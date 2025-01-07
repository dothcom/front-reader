<?php

namespace Dothnews\FrontReader\Services;

use Illuminate\Support\Facades\View;

class PageService extends BaseService
{
    public function getPage(string $slug)
    {
        $url = config('front-reader.api_url').'/pages/slug/'.$slug;

        return $this->makeRequest($url);
    }

    public function templateByType(string $page_type = 'page'): string
    {
        $template = 'page.index';

        if ($page_type == 'contact') {
            $template = 'page.contact-form';
        } elseif ($page_type == 'html') {
            $template = 'page.html';
        } elseif ($page_type == 'news') {
            $template = 'category.index';
        } elseif (str_starts_with($page_type, 'news-') || str_starts_with($page_type, 'page-')) {
            $tpl = str_replace(['news-', 'page-'], ['news.', 'page.'], $page_type);

            if (View::exists($tpl)) {
                $template = $tpl;
            }
        }

        return $template;
    }
}
