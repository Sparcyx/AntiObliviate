<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    protected $table = 'animes';
    protected $fillable = ['titre', 'nombre_depisodes', 'url_image', 'idAPI'];

    // Relation avec la table user_anime
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_anime');
    }

    public function fiche()
    {
        return $this->hasOne(FicheAnime::class);
    }

    public function getAnimesByCategory($categoryName)
    {
        $category = Category::where('name', $categoryName)->first();
        $animes = Anime::where('category_id', $category->id)->get();

        return view('animes.index', compact('animes'));
    }
}
