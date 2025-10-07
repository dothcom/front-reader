<?php

namespace Dothcom\FrontReader\Services;

class ContentTypeResolver
{
    private const EXTENSION_PATTERN = '/\.([a-z]+)$/i';

    private const CONTENT_TYPES = [
        'txt' => 'text/plain',
        'html' => 'text/html',
        'xml' => 'application/xml',
        'json' => 'application/json',
        'rss' => 'application/rss+xml',
        'atom' => 'application/atom+xml',
        'csv' => 'text/csv',
        'js' => 'application/javascript',
        'css' => 'text/css',
    ];

    public function resolve(string $permalink): ContentType
    {
        $extension = $this->extractExtension($permalink);

        return new ContentType($this->getContentType($extension));
    }

    private function extractExtension(string $permalink): string
    {
        if (! preg_match(self::EXTENSION_PATTERN, $permalink, $matches)) {
            return 'html';
        }

        return strtolower($matches[1]);
    }

    private function getContentType(string $extension): string
    {
        return self::CONTENT_TYPES[$extension] ?? self::CONTENT_TYPES['html'];
    }
}
