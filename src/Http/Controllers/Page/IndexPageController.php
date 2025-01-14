<?php

namespace DothNews\FrontReader\Http\Controllers\Page;

use DothNews\FrontReader\Http\Controllers\BaseController;
use Dothnews\FrontReader\Services\PageService;

class IndexPageController extends BaseController
{
    public function index($slug = 'ultimas-noticias')
    {
        $pageService = new PageService();
        $page = $pageService->getPage($slug);
        $template = $pageService->templateByType($page->data->page_type);

        $data = [
            'slug' => $slug,
            'page' => $page->data,
        ];

        return view($template, $data);
    }

    public function listByPage($slug)
    {
        return $this->index($slug);
    }
}
