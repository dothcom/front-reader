<?php

namespace DothNews\FrontReader\Http\Controllers\Page;

use DothNews\FrontReader\Http\Controllers\BaseController;
use Dothnews\FrontReader\Services\PageService;
use Illuminate\Support\Facades\View;

class IndexPageController extends BaseController
{
    public function index($slug = 'ultimas-noticias')
    {
        $pageService = new PageService();
        $page = $pageService->getPage($slug);

        if (! isset($page->data->id)) {
            abort(404);
        }

        $tpl = $pageService->templateByType($page->data->page_type);

        if ($tpl === 'page.html') {
            return $this->outputContent($page->data->link, $page->data->content);
        }

        if (! View::exists($tpl)) {
            abort(404);
        }

        $data = [
            'slug' => $slug,
            'page' => $page->data,
        ];

        return view($tpl, $data);
    }

    public function listByPage($slug)
    {
        return $this->index($slug);
    }

    private function outputContent(string $link, string $content = '')
    {
        $content_type = 'text/html';

        if (substr($link, -4) === '.txt') {
            $content_type = 'text/plain';
        } elseif (substr($link, -3) === '.js') {
            $content_type = 'application/javascript';
        } elseif (substr($link, -5) === '.json') {
            $content_type = 'application/json';
        }

        return response($content, 200)->header('Content-Type', $content_type);
    }
}
