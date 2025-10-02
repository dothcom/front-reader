<?php

namespace Dothcom\FrontReader\Services;

class TagService extends BaseService
{
    public function getTags(array $options = [])
    {
        $response = $this->tryRequest('/tags/', $options);

        if (isset($response->message) || isset($response->errors)) {
            return $response;
        }

        return $this->paginateSimple($response);
    }

    public function getTag(string $slug)
    {
        $tag = $this->tryRequest('/tags/slug/'.$slug);

        if (!isset($tag->data->name)) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

        return $tag;
    }
}
