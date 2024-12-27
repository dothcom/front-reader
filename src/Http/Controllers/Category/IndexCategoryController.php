<?php

namespace DothNews\FrontReader\Http\Controllers\Category;

use Illuminate\Routing\Controller;

class IndexCategoryController extends Controller
{
    public function index($slug = 'ultimas-noticias')
    {
        return view('category.index', [ 'slug' => $slug ]);
    }

    public function listByCategory($slug)
    {
        return $this->index($slug);
    }
}
