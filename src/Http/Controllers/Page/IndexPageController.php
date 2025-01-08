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

        $template = $pageService->templateByType($page->data->page_type);

        if (! View::exists($template)) {
            abort(404);
        }

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
