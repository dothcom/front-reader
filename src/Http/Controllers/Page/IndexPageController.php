<?php

namespace DothNews\FrontReader\Http\Controllers\Page;

use DothNews\FrontReader\Http\Controllers\BaseController;
use Dothnews\FrontReader\Services\PageService;
use Illuminate\Support\Facades\View;

class IndexPageController extends BaseController
{
    public function index($slug = 'ultimas-noticias')
    {
        $page = $this->getPageData($slug);

        if (! isset($page->data->id)) {
            abort(404);
        }

        $template = $this->resolveTemplate($page->data->page_type);

        if ($template === 'page.html') {
            return $this->outputContent($page->data->link, $page->data->content);
        }

        if (! View::exists($template)) {
            abort(404);
        }

        return $this->renderTemplate($template, $slug, $page->data);
    }

    public function listByPage($slug)
    {
        return $this->index($slug);
    }

    private function getPageData(string $slug)
    {
        $pageService = new PageService();

        return $pageService->getPage($slug);
    }

    private function resolveTemplate(string $pageType): string
    {
        $pageService = new PageService();

        return $pageService->templateByType($pageType);
    }

    private function renderTemplate(string $template, string $slug, $pageData)
    {
        $data = [
            'slug' => $slug,
            'page' => $pageData,
        ];

        return view($template, $data);
    }

    private function outputContent(string $link, string $content = '')
    {
        $contentType = $this->resolveContentType($link);

        return response($content, 200)->header('Content-Type', $contentType);
    }

    private function resolveContentType(string $link): string
    {
        return match (pathinfo($link, PATHINFO_EXTENSION)) {
            'txt' => 'text/plain',
            'js' => 'application/javascript',
            'json' => 'application/json',
            default => 'text/html',
        };
    }
}
