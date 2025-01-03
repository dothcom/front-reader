<?php

namespace DothNews\FrontReader\Http\Controllers;

use GuzzleHttp\Client;

class IndexController extends BaseController
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

        // dd($apiUrl, $apiKey);

        //return response()->json($news);
        return view('index');
    }
}
