<?php

namespace Dothnews\FrontReader\Services;

class PostService
{
    public function getLatestNews(int $limit = 10)
    {
        // Implementação do serviço
        $allNews = [
            ['title' => 'Notícia de teste 1 com titulo grande', 'date' => '2019-01-01' , 'editoria' => 'política' ,
                'url' => 'http://example.com/noticia-1' , 'image' => 'https://via.placeholder.com/300x250'],

            ['title' => 'Coritiba vence o criciuma', 'date' => '2019-01-02' , 'editoria' => 'esporte' ,
                'url' => 'http://example.com/noticia-2' , 'image' => 'https://via.placeholder.com/300x250'],

            ['title' => 'Prefeito corre', 'date' => '2019-01-02' , 'editoria' => 'esporte' ,
                'url' => 'http://example.com/noticia-2' , 'image' => 'https://via.placeholder.com/300x250'],

        ];

        // return with limit
        return array_slice($allNews, 0, $limit);
    }
}
