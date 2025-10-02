<?php

namespace Dothcom\FrontReader\Http\Controllers\Tag;

use Dothcom\FrontReader\Http\Controllers\BaseController;
use Dothcom\FrontReader\Services\TagService;

class DetailTagController extends BaseController
{
    public function index($slug)
    {
        $tagService = new TagService();
        $tag = $tagService->getTag($slug)->data ?? null;

        abort_if(!$tag || empty($tag->name), 404);

        return response()->view('tag.detail', ['tag' => $tag]);
    }
}
