<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Category;
use App\Models\AnimeRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AnimeController extends Controller
{
    public function myAnimeList()
    {
        $user = Auth::user();
        $animes = $user->animes()->with(['animeRecords' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->paginate(10);

        $categories = Category::all();

        return view('anime.index', compact('animes', 'user', 'categories'));
    }

    public function filterAnimes(Request $request)
    {
        // Récupérez l'utilisateur actuel
        $user = Auth::user();
    
        // Récupérez les paramètres de recherche et de tri
        $search = $request->input('search', null);
        $order = $request->input('order', null);
        $category = $request->input('category', null);
        $page = $request->input('page', 1);
        $limit = 10;
    
        // Récupérez tous les animes de l'utilisateur avec les détails des épisodes regardés
        $animes = $user->animes()
            ->join('anime_records', 'anime_records.anime_id', '=', 'animes.id')
            ->where('anime_records.user_id', $user->id)
            ->select('animes.*', 'anime_records.watch_date', 'anime_records.category_id')
            ->when($search, function ($query, $search) {
                return $query->where('animes.title', 'like', '%' . $search . '%');
            });
    
        // Appliquez les ordres de tri
        if (!empty($order)) {
            foreach ($order as $sort) {
                switch ($sort) {
                    case 'alphabetical':
                        $animes = $animes->orderBy('animes.title');
                        break;
                    case 'last_watched':
                        $animes = $animes->orderByDesc('anime_records.watch_date');
                        break;
                }
            }
        }
    
        // Filter by category
        if (!empty($category)) {
            $animes = $animes->where('anime_records.category_id', $category);
        }
    
        $animes = $animes->paginate($limit);
    
        // Fetch all categories
        $categories = Category::all();
    
        return view('anime.index', compact('animes', 'user', 'categories'));
    }

    public function addToList(Request $request, $id)
    {
        $user = Auth::user();
        $anime = Anime::find($id);

        if (!$anime) {
            $animeData = $this->getAnimeDataFromAPI($id);
            $anime = new Anime();
            $anime->id = $id;
            $anime->title = $animeData->title;
            $anime->number_of_episodes = $animeData->num_episodes;
            $anime->image_url = $animeData->main_picture->medium;
            $anime->api_id = $id;
            $anime->save();
        }

        $animeRecord = new AnimeRecord();
        $animeRecord->last_episode_watched = 0;
        $animeRecord->watch_date = now();
        $animeRecord->add_date = now();
        $animeRecord->category_id = 1;
        $animeRecord->anime_id = $anime->id;
        $animeRecord->user_id = $user->id;
        $animeRecord->save();

        $user->animes()->attach($anime->id, ['created_at' => now(), 'updated_at' => now()]);

        return redirect()->route('anime.show', $anime->id);
    }

    private function getAnimeDataFromAPI($id)
    {
        $url = "https://anime-api-dsfj.onrender.com/anime/{$id}";
        $response = Http::get($url);

        if ($response->successful()) {
            return json_decode($response->body());
        }

        return null;
    }
}
