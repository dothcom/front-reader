<?php

namespace Dothcom\FrontReader\Services;

use Illuminate\Support\Facades\View;

class PostService extends BaseService
{
    public function getLatestNews(array $options = [])
    {
        $response = $this->tryRequest('/posts/', $options);

        if (isset($response->message) || isset($response->errors)) {
            return $response;
        }

        return $this->paginateResponse($response);
    }

    public function getPostBySlug(string $slug, array $options = [])
    {
        $url = '/posts/slug/'.$slug;

        $response = $this->tryRequest($url, $options);

        if (! isset($response->data) || ! $this->isPublished($response->data)) {
            return false;
        }

        return $this->tryRequest($url, $options);
    }

    /**
     * @param  string  $post_type  - um dos tipos em PostTypeEnum: gallery, podcast, post, recipe, video, webstory
     */
    public function templateByType(string $post_type = 'post'): string
    {
        $dir = 'post.';
        $template = 'detail';

        return $dir.(View::exists($dir.$post_type) ? $post_type : $template);
    }

    /**
     * Extracts URLs from iframes in an HTML content.
     *
     * @param  string  $html  The HTML content containing iframes
     * @param  bool  $first  If TRUE, returns the first URL; if FALSE, returns an array with all URLs
     * @return string|array|null The URL of the first iframe or an array with all iframe URLs.
     */
    public function getIframeUrl(string $html, ?bool $first = false)
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
    public function getThumbnailUrl(?string $videoUrl, ?string $youtube_size = 'mqdefault'): ?string
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

    private function isPublished($post)
    {
        if ($post->visibility === 'Publish' and $post->published_at <= now()) {
            return true;
        }

        return false;
    }
}
