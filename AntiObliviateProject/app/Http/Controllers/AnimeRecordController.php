<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Category;
use App\Models\AnimeRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class AnimeRecordController extends Controller
{
    public function show($id)
    {
        // Récupérer les données de l'anime depuis l'API
        $client = new Client();
        $response = $client->get("https://anime-api-dsfj.onrender.com/anime/{$id}");
        $anime = json_decode($response->getBody());

        // Récupérer la AnimeRecord associée à l'anime et à l'utilisateur authentifié
        $user = Auth::user();
        $AnimeRecord = AnimeRecord::where('anime_id', $id)->where('user_id', $user->id)->first();

        $categories = Category::all();

        // Déterminer si l'anime se trouve dans la liste de l'utilisateur
        $animeInUserList = $user->animes()->where('anime_id', $id)->exists();

        return view('anime.show', compact('anime', 'AnimeRecord', 'animeInUserList', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Valider les données soumises
        $request->validate([
            'watch_date' => 'nullable|date',
            'last_episode_watched' => 'nullable|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Trouver l'anime correspondant
        $anime = Anime::findOrFail($id);

        // Trouver la fiche anime correspondante pour l'utilisateur actuel
        $AnimeRecord = $anime->animeRecords()->where('user_id', $user->id)->firstOrFail();
        // Mettre à jour les informations de la fiche
        $AnimeRecord->watch_date = $request->input('watch_date');

        // Vérifier si l'épisode vu est supérieur au nombre total d'épisodes
        $last_episode_watched = $request->input('last_episode_watched');
        if ($last_episode_watched > $anime->number_of_episodes) {
            $last_episode_watched = $anime->number_of_episodes;
        }
        $AnimeRecord->last_episode_watched = $last_episode_watched;

        $AnimeRecord->category_id = $request->input('category_id');

        // Enregistrer les modifications dans la base de données
        $AnimeRecord->save();

        // Rediriger l'utilisateur vers la page de détail avec un message de succès
        return redirect()->route('anime.show', $id)->with('success', 'Les modifications ont été enregistrées avec succès.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
    
        // Find the AnimeRecord and delete it
        $AnimeRecord = AnimeRecord::where('anime_id', $id)->where('user_id', $user->id)->first();
        
        if ($AnimeRecord) {
            $AnimeRecord->delete();
            // Detach the anime from the user
            $user->animes()->detach($id);

            return redirect()->back()->with('success', 'Anime supprimé de la liste.');
        } else {
            return redirect()->back()->with('error', 'Fiche Anime non trouvée.');
        }
    }
}
