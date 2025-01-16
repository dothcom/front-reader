<?php

namespace Dothcom\FrontReader\Http\Controllers\Post;

use GuzzleHttp\Client;
use Illuminate\Routing\Controller;

class IndexPostController extends Controller
{
    // protected $client;

    // public function __construct(Client $client)
    // {
    //     $this->client = $client;
    // }

    public function index()
    {
        //$response = $this->client->get("https://6d7d0164796742fcb625a3fc36f32ae2.api.mockbin.io/");
        //$news = json_decode($response->getBody(), true);

        // open front-reader config

        // $apiUrl = config('front-reader.api_url');
        // $apiKey = config('front-reader.api_key');

        //return response()->json($news);
        return view('post.index');
    }
}
