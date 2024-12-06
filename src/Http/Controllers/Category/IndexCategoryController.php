<?php

namespace DothNews\FrontReader\Http\Controllers\Category;

use GuzzleHttp\Client;
use Illuminate\Routing\Controller;

class IndexCategoryController extends Controller
{
    public function index($slug='ultimas-noticias')
    {
        $data = [
            'slug' => $slug,
            'editoria' => 'ultimas-noticias'
        ];

        return view('category.index', $data);
    }

    public function listByCategory($slug)
    {
        return $this->index($slug);
    }
}
