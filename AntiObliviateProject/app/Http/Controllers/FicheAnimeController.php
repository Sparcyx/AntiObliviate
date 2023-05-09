<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Category;
use App\Models\FicheAnime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FicheAnimeController extends Controller
{
    public function show($id)
    {
        // Récupérer les données de l'anime depuis l'API
        $client = new \GuzzleHttp\Client();
        $response = $client->get("https://anime-api-dsfj.onrender.com/anime/{$id}");
        $anime = json_decode($response->getBody());

        // Récupérer la FicheAnime associée à l'anime
        $ficheAnime = FicheAnime::where('anime_id', $id)->first();

        // Récupérer les informations de la table user_anime pour l'utilisateur authentifié
        $user = Auth::user();
        $animeInUserList = $user->animes()->where('anime_id', $id)->exists();

        $categories = Category::all();

        return view('anime.show', compact('anime', 'ficheAnime', 'animeInUserList', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Valider les données soumises
        $request->validate([
            'date_visionnage' => 'nullable|date',
            'dernier_episode_vu' => 'nullable|integer|min:1',
            'categorie' => 'required|exists:categories,id',
        ]);

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Trouver l'anime correspondant
        $anime = Anime::findOrFail($id);

        // Trouver la fiche anime correspondante
        $ficheAnime = $anime->ficheAnimes()->firstOrFail();

        // Vérifier que l'utilisateur actuel a bien une relation avec cet anime
        if ($anime->users->contains($user)) {
            // Mettre à jour les informations de la fiche
            $ficheAnime->date_visionnage = $request->input('date_visionnage');

            // Vérifier si l'épisode vu est supérieur au nombre total d'épisodes
            $dernier_episode_vu = $request->input('dernier_episode_vu');
            if ($dernier_episode_vu > $anime->nombre_depisodes) {
                $dernier_episode_vu = $anime->nombre_depisodes;
            }
            $ficheAnime->dernier_episode_vu = $dernier_episode_vu;

            $ficheAnime->categorie_id = $request->input('categorie');

            // Enregistrer les modifications dans la base de données
            $ficheAnime->save();

            // Rediriger l'utilisateur vers la page de détail avec un message de succès
            return redirect()->route('anime.show', $id)->with('success', 'Les modifications ont été enregistrées avec succès.');
        } else {
            // Rediriger l'utilisateur vers la page de détail avec un message d'erreur
            return redirect()->route('anime.show', $id)->with('error', 'Vous n\'avez pas les droits pour modifier cette fiche.');
        }
    }
}
