<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://anime-api-dsfj.onrender.com/anime');
        $animes = json_decode($response->getBody());
    
        return view('anime.index', compact('animes'));
    }
}
