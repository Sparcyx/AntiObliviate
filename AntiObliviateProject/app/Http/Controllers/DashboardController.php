<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = 16;

        $client = new \GuzzleHttp\Client();
        $response = $client->get("https://anime-api-dsfj.onrender.com/anime?_page={$page}&_limit={$limit}");
        $animes = json_decode($response->getBody());

        // Get the total count of animes from the API
        $totalCount = $response->getHeader('x-total-count')[0];

        // Create a Paginator instance with the data
        $animes = new \Illuminate\Pagination\LengthAwarePaginator($animes, $totalCount, $limit, $page, [
            'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
        ]);

        return view('dashboard', compact('animes'));
    }

    public function show($id)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get("https://anime-api-dsfj.onrender.com/anime/{$id}");
        $anime = json_decode($response->getBody());

        return view('anime.show', compact('anime'));
    }
}
