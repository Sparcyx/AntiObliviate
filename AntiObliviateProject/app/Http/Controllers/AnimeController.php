<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\FicheAnime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AnimeController extends Controller
{
    public function myAnimeList()
    {
        $user = Auth::user();
        $animes = $user->animes()->with('fiche')->paginate(10);

        return view('anime.index', compact('animes', 'user'));
    }

    public function ajouterALaListe(Request $request, $id)
    {
        $user = Auth::user();
        $anime = Anime::find($id);

        if (!$anime) {
            $animeData = $this->getAnimeDataFromAPI($id);
            $anime = new Anime();
            $anime->id = $id;
            $anime->titre = $animeData->title;
            $anime->nombre_depisodes = $animeData->num_episodes;
            $anime->url_image = $animeData->main_picture->medium;
            $anime->idAPI = $id;
            $anime->save();
        }

        $ficheAnime = new FicheAnime();
        $ficheAnime->dernier_episode_vu = 0;
        $ficheAnime->date_visionnage = now();
        $ficheAnime->date_ajout = now();
        $ficheAnime->categorie_id = 1;
        $ficheAnime->anime_id = $anime->id;
        $ficheAnime->save();

        $user->animes()->attach($anime->id, ['created_at' => now(), 'updated_at' => now()]);

        return redirect()->route('anime.show', $anime->id);
    }


    private function getAnimeDataFromAPI($id)
    {
        $apiKey = env('API_KEY');
        $url = "https://anime-api-dsfj.onrender.com/anime/{$id}";
        $response = Http::get($url);

        if ($response->successful()) {
            return json_decode($response->body());
        }

        return null;
    }

    public function supprimer_anime_route($id)
    {
        $user = Auth::user();
    
        // Detach the anime from the user
        $user->animes()->detach($id);
    
        // Delete the fiche_anime
        FicheAnime::where('anime_id', $id)->delete();
    
        return redirect()->back()->with('success', 'Anime supprimé de la liste.');
    }
}
