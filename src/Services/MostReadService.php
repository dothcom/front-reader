<?php

namespace Dothnews\FrontReader\Services;

use Illuminate\Support\Collection;

class MostReadService extends DataFetcherService
{
    public function getMostRead(array $options = [])
    {
        $limit = isset($options['limit']) && $options['limit'] > 0 ? $options['limit'] : 5;
        $ttl = isset($options['ttl']) && $options['ttl'] > 0 ? $options['ttl'] : 4;
        $host = isset($options['host']) && $options['host'] != '' ? $options['host'] : parse_url(config('app.url'), PHP_URL_HOST);
        $url = 'https://dn-commons.nyc3.cdn.digitaloceanspaces.com/ga4_mais_lidas/'.$host.'/mais_lidas.json';

        $content = $this->download($url, 'json/mais_lidas/data.json', $ttl);
        //dd($content);
    }

    public function getPostsFromContent(array $content, int $limit): Collection
    {
        $pagePaths = collect($content['registros'])
            ->pluck('pagePath')
            ->filter(function ($path) {
                return $path !== '(not set)';
            })
            ->toArray();

        /*
        TO-DO:

        - Implementar na API: busca de post por PATH para o mais lidas

        $posts = Post::whereIn('slug', $pagePaths)->get();

        $orderedPosts = collect($content['registros'])->map(function ($registro) use ($posts) {
            return $posts->firstWhere('slug', $registro['pagePath']);
        })->filter();

        return $orderedPosts->take($limit);
        */
    }
}
