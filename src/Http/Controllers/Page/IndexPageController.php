<?php

namespace Dothcom\FrontReader\Http\Controllers\Page;

use Dothcom\FrontReader\Http\Controllers\BaseController;
use Dothcom\FrontReader\Services\PageService;

class IndexPageController extends BaseController
{
    public function index($slug)
    {
        $pageService = new PageService();
        $page = $pageService->getPage($slug);

        $template = $pageService->templateByType($page->data->page_type);

        if (! view()->exists($template)) {
            report('Page template not found', ['slug' => $slug, 'template' => $template]);
            abort();
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
