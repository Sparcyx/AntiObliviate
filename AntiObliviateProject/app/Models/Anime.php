<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    protected $table = 'animes';
    protected $fillable = ['title', 'number_of_episodes', 'image_url', 'api_id'];

    // Relation avec la table user_anime
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_anime');
    }

    // Relation avec la table anime_records
    public function animeRecords()
    {
        return $this->hasMany(AnimeRecord::class);
    }
}