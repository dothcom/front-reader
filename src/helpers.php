<?php

if (! function_exists('organizeMenu')) {
    /**
     * Organizes a list of pages into a hierarchical structure
     *
     * @param  array  $pages  - An array of page objects to be organized
     * @return array
     */
    function organizeMenu($pages)
    {
        $pagesById = [];
        foreach ($pages as $page) {
            $page->pages = [];
            $pagesById[$page->id] = $page;
        }

        $organizedMenu = [];
        foreach ($pages as $page) {
            if ($page->parent_id && isset($pagesById[$page->parent_id])) {
                $pagesById[$page->parent_id]->pages[] = $page;
            } else {
                $organizedMenu[] = $page;
            }
        }

        return $organizedMenu;
    }
}

if (! function_exists('getIframeUrl')) {
    /**
     * Extracts URLs from iframes in an HTML content.
     *
     * @param  string  $html  The HTML content containing iframes
     * @param  bool  $first  If TRUE, returns the first URL; if FALSE, returns an array with all URLs
     * @return string|array|null The URL of the first iframe or an array with all iframe URLs.
     */
    function getIframeUrl(string $html, ?bool $first = false)
    {
        preg_match_all('/<iframe.*?src=["\']([^"\']+)["\'].*?>/i', $html, $matches);

        if (empty($matches[1])) {
            return null;
        }

        if ($first) {
            return $matches[1][0];
        }

        return $matches[1];
    }
}

if (! function_exists('getThumbnailUrl')) {
    /**
     * Generates the thumbnail URL for a video URL.
     *
     * @param  string|null  $videoUrl  The video URL.
     * @param  string  $youtube_size  One of YouTube's image sizes:
     *                                default -
     *                                sddefault - Low quality thumbnail
     *                                mqdefault - Medium quality thumbnail
     *                                hqdefault - High quality thumbnail
     *                                maxresdefault - Maximum quality thumbnail
     * @return string|null The thumbnail URL or null if the platform is not supported.
     */
    function getThumbnailUrl(?string $videoUrl, ?string $youtube_size = 'mqdefault'): ?string
    {
        $parsedUrl = parse_url($videoUrl);
        $host = $parsedUrl['host'] ?? '';
        $path = $parsedUrl['path'] ?? '';

        // URLs from YouTube
        if (str_contains($host, 'youtube.com') || str_contains($host, 'youtu.be')) {
            $formatos = ['default', 'hqdefault', 'mqdefault', 'sddefault', 'maxresdefault'];
            $formato = in_array($youtube_size, $formatos) ? $youtube_size : 'mqdefault';

            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoUrl, $matches);

            return isset($matches[1]) ? 'http://img.youtube.com/vi/'.$matches[1].'/'.$formato.'.jpg' : null;
        }

        // URLs from Vimeo
        if (str_contains($host, 'vimeo.com')) {
            $videoId = trim($path, '/');

            return $videoId ? "https://vumbnail.com/{$videoId}.jpg" : null;
        }

        return null;
    }
}
