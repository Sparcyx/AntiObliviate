<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FicheAnime extends Model
{
    protected $table = 'fiche_animes';
    protected $fillable = ['dernier_episode_vu', 'date_visionnage', 'date_ajout', 'categorie_id'];

    // Relation avec la table categories
    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }
}
