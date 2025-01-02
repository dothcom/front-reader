<?php

namespace Dothnews\FrontReader\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DataFetcherService extends BaseService
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
            throw new \Exception('Error processing URL: '.$e->getMessage());
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
            throw new \Exception('JSON Error: '.json_last_error_msg());
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
            throw new \Exception("Error downloading JSON from URL: $url");
        }

        $jsonContent = $response->body();
        Storage::disk('local')->put($path, $jsonContent);

        $decodedJson = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON Error: '.json_last_error_msg());
        }

        return $decodedJson;
    }
}
