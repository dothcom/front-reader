<?php

namespace Dothcom\FrontReader\Services;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class BaseService
{
    public $apiUrl;
    public $apiVersion;

    protected function getApiUrl(): string
    {
        return config('front-reader.api_url') . config('front-reader.api_version');
    }

    private function makeRequest(string $url, array $options = [])
    {
        $response = Http::accept('application/json')
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-Forwarded-For' => request()->ip(),
                'User-Agent' => request()->header('User-Agent').' - FrontReader',
            ])
            ->get($url, $options);

        $this->handleCommonExceptions($response);

        // \Illuminate\Support\Facades\Log::info('makeRequest', ['url' => $url]);
        return $response->object();
    }

    protected function tryRequest(string $endpoint, array $options = [], bool $useCache = false, int $cacheSeconds = 10)
    {
        $url = $this->getApiUrl().$endpoint;

        $cacheKey = md5($endpoint . json_encode($options, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK));

        if ($useCache && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = $this->makeRequest($url, $options);
            if ($useCache) {
                Cache::put($cacheKey, $response, $cacheSeconds);
            }

            return $response;
        } catch (TooManyRequestsHttpException $e) {
            throw $e;
        } catch (NotFoundHttpException $e) {
            return [];
        } catch (Exception $e) {
            throw new Exception('Erro ao tentar se comunicar com a API: '.$e->getMessage());
        }
    }

    protected function handleCommonExceptions($response)
    {
        switch ($response->status()) {
            case 401:
                throw new Exception('Unauthorized API Key');
            case 403:
                throw new Exception('Forbidden - Maybe Unauthorized API Key');
            case 404:
                throw new NotFoundHttpException('Resource not found');
            case 429:
                $retryAfter = $response->header('Retry-After') ?? 300;
                throw new TooManyRequestsHttpException($retryAfter, 'Too Many Requests');
            case 500:
                throw new Exception('Internal Server Error');
        }
    }

    protected function paginateResponse($response)
    {
        if (! is_object($response) ||
            ! property_exists($response, 'data') ||
            ! property_exists($response, 'meta') ||
            ! is_object($response->meta)) {
            throw new InvalidArgumentException('The response format is invalid.');
        }

        $requiredMeta = ['total', 'per_page', 'current_page'];
        foreach ($requiredMeta as $key) {
            if (! property_exists($response->meta, $key)) {
                throw new InvalidArgumentException("Meta data property is missing '{$key}'.");
            }
        }

        $items = $response->data instanceof Collection ? $response->data : collect($response->data);

        return new LengthAwarePaginator(
            $items,
            $response->meta->total,
            $response->meta->per_page,
            $response->meta->current_page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }
}
