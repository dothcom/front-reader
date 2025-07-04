<?php

namespace Dothcom\FrontReader\Services;

use Illuminate\Support\Facades\View;

class PageService extends BaseService
{
    public function getPage(string $permalink)
    {
        $slug = basename(rtrim(parse_url($permalink, PHP_URL_PATH) ?: '', '/'));


        $page = $this->tryRequest('/pages/slug/'.$slug);

        if ($page->data->permalink != $permalink) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        return $page;
    }

    public function getPermalinks()
    {
        $endpoint = '/pages/permalink/';

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
