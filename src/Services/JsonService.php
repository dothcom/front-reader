<?php

namespace Dothnews\FrontReader\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JsonService extends BaseService
{
    public function download(string $url, string $filename, float $hours = 1): array
    {
        try {
            $path = 'temp/'.$filename;

            if ($this->shouldUseCache($path, $hours)) {
                return $this->getCachedJson($path);
            }

            return $this->fetchAndCacheJson($url, $path);
        } catch (\Exception $e) {
            throw new \Exception('Erro ao processar a URL: '.$e->getMessage());
        }
    }

    /**
     * Verifica se deve usar o cache com base no tempo de expiração.
     */
    private function shouldUseCache(string $path, float $hours): bool
    {
        if (! Storage::disk('local')->exists($path)) {
            return false;
        }

        $lastModified = Storage::disk('local')->lastModified($path);
        $timeDiffInHours = (time() - $lastModified) / 3600;

        return $timeDiffInHours <= $hours;
    }

    /**
     * Obtém o JSON do cache e o decodifica.
     */
    private function getCachedJson(string $path): array
    {
        $cachedContent = Storage::disk('local')->get($path);
        $decodedJson = json_decode($cachedContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Erro ao decodificar JSON em cache: '.json_last_error_msg());
        }

        return $decodedJson;
    }

    /**
     * Faz o download do JSON, armazena no cache e retorna o conteúdo decodificado.
     */
    private function fetchAndCacheJson(string $url, string $path): array
    {
        $response = Http::get($url);

        if ($response->failed()) {
            throw new \Exception("Erro ao baixar JSON da URL: $url");
        }

        $jsonContent = $response->body();
        Storage::disk('local')->put($path, $jsonContent);

        $decodedJson = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Erro ao decodificar JSON: '.json_last_error_msg());
        }

        return $decodedJson;
    }

    public function slugfy(string $texto): string
    {
        $isSlug = preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $texto) === 1;

        if ($isSlug) {
            return $texto;
        }

        return Str::slug($texto);
    }

    public function getPrevisao($cidade, $ttl = 2)
    {
        $slug = $this->slugfy($cidade);
        $url = 'https://dn-commons.dothnews.com.br/previsao-do-tempo/'.$slug.'.json';

        return $this->download($url, 'json/previsao_tempo/'.$slug.'.json', $ttl);
    }

    public function getMaisLidas(array $options = [])
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
