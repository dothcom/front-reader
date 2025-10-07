<?php

namespace Dothcom\FrontReader\Http\Controllers\Page;

use Dothcom\FrontReader\Http\Controllers\BaseController;
use Dothcom\FrontReader\Services\ContentTypeResolver;
use Dothcom\FrontReader\Services\PageService;
use Illuminate\Http\Response;

class IndexPageController extends BaseController
{
    public function __construct(
        private readonly ContentTypeResolver $contentTypeResolver
    ) {
    }

    public function index($slug): Response
    {
        $pageService = new PageService();
        $page = $pageService->getPage($slug);

        $contentType = $this->contentTypeResolver->resolve($slug);

        $template = $pageService->templateByType($page->data->page_type);

        if (! view()->exists($template)) {
            report('Page template not found', ['slug' => $slug, 'template' => $template]);
            abort();
        }

        $data = [
            'slug' => $slug,
            'page' => $page->data,
        ];

        return response()
            ->view($template, $data)
            ->header('Content-Type', $contentType->toString());
    }

    public function listByPage($slug)
    {
        return $this->index($slug);
    }
}
