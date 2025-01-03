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
        } elseif (View::exists($page_type)) {
            $template = $page_type;
        }

        return $template;
    }
}
