<?php

namespace Dothcom\FrontReader\Services;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseService
{
    protected function makeRequest(string $url, array $options = [])
    {
        $response = Http::accept('application/json')
            ->withToken(config('front-reader.api_key'))
            ->get($url, $options);

        $this->handleCommonExceptions($response);

        return $response->object();
    }

    protected function tryRequest(string $url, array $options = [])
    {
        try {
            return $this->makeRequest($url, $options);
        } catch (NotFoundHttpException $e) {
            return [];
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
