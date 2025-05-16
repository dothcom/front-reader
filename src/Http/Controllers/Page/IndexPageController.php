<?php

namespace Dothcom\FrontReader\Http\Controllers\Page;

use Dothcom\FrontReader\Http\Controllers\BaseController;
use Dothcom\FrontReader\Services\PageService;

class IndexPageController extends BaseController
{
    public function index($slug)
    {
        $segments = array_filter(explode('/', $slug));
        $slug = end($segments);
        $pageService = new PageService();
        $page = $pageService->getPage($slug);

        $template = $pageService->templateByType($page->data->page_type);

        if (! view()->exists($template)) {
            abort(500);
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
