<?php

namespace Dothcom\FrontReader\Services;

use Illuminate\Support\Facades\View;

class PageService extends BaseService
{
    public function getPage(string $slug)
    {
        $endpoint = '/pages/slug/'.$slug;

        return $this->tryRequest($endpoint);
    }

    public function getSlugs()
    {
        $endpoint = '/pages/slugs/';

        return $this->tryRequest($endpoint);
    }

    public function templateByType(string $page_type = 'page'): string
    {
        $template_padrao = 'page.index';
        $template = $template_padrao;

        if ($page_type == 'contact') {
            $template = 'page.contact-form';
        } elseif ($page_type == 'html') {
            $template = 'page.html';
        } elseif ($page_type == 'news') {
            $template = 'post.index';
        } elseif (str_starts_with($page_type, 'news-') || str_starts_with($page_type, 'page-')) {
            $tpl = str_replace(['news-', 'page-'], ['news.', 'page.'], $page_type);

            if (View::exists($tpl)) {
                $template = $tpl;
            }
        }

        return View::exists($template) ? $template : $template_padrao;
    }
}
