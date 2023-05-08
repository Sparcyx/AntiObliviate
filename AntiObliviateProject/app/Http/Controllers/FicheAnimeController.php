<?php

namespace App\Http\Controllers;

use App\Models\FicheAnime;
use Illuminate\Http\Request;

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
    
        // Retourner les deux objets à la vue
        return view('anime.show', compact('anime', 'ficheAnime'));
    }

    public function update(Request $request, $id)
    {
        // Valider les données soumises
        $request->validate([
            'date_visionnage' => 'nullable|date',
            'dernier_episode_vu' => 'nullable|integer|min:1',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        // Trouver la fiche anime correspondante
        $ficheAnime = FicheAnime::findOrFail($id);

        // Mettre à jour les informations de la fiche
        $ficheAnime->date_visionnage = $request->input('date_visionnage');
        $ficheAnime->dernier_episode_vu = $request->input('dernier_episode_vu');
        $ficheAnime->categorie_id = $request->input('categorie_id');

        // Enregistrer les modifications dans la base de données
        $ficheAnime->save();

        // Rediriger l'utilisateur vers la page de détail avec un message de succès
        return redirect()->route('fiche_anime.show', $id)->with('success', 'Les modifications ont été enregistrées avec succès.');
    }
}
