<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['titre'];

    // Relation avec la table fiche_animes
    public function ficheAnimes()
    {
        return $this->hasMany(FicheAnime::class, 'categorie_id');
    }
}