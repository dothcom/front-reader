<?php

namespace Dothnews\FrontReader\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

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

    protected function handleCommonExceptions($response)
    {
        switch ($response->status()) {
            case 401:
                throw new Exception('Unauthorized API Key');
            case 404:
                throw new NotFoundHttpException('Resource not found');
            case 500:
                throw new Exception('Internal Server Error');
            // Você pode adicionar mais códigos de status conforme necessário
        }
    }
}
