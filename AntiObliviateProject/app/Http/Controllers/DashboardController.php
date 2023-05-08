<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function searchAnimes(Request $request)
    {
        $search = $request->input('search');
        $currentPage = $request->input('page', 1);
        $orders = $request->input('order', []);
    
        // Récupérez les résultats de l'API
        $apiUrl = "https://anime-api-dsfj.onrender.com/anime/?q={$search}&_limit=1000";
        $response = Http::get($apiUrl);
        $data = $response->json();
    
        // Appliquez les ordres de tri
        if (in_array('alphabetical', $orders)) {
            usort($data, function ($a, $b) {
                return strcmp($a['title'], $b['title']);
            });
        }
        // ... ajoutez les autres ordres de tri ici
    
        // Convertissez les tableaux associatifs en objets
        $data = json_decode(json_encode($data), false);
    
        // Créez une collection à partir des données filtrées et triées
        $dataCollection = collect($data);
    
        // Calculez les éléments à afficher pour la pagination
        $perPage = 16;
        $offset = ($currentPage - 1) * $perPage;
        $items = $dataCollection->slice($offset, $perPage);
    
        // Créez une nouvelle instance de LengthAwarePaginator avec les résultats de l'API
        $animes = new LengthAwarePaginator($items, count($data), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);
    
        // Retournez la vue avec les résultats paginés
        return view('dashboard', compact('animes'));
    }
}
