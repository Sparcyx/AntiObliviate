<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['title'];

    // Relation avec la table anime_records
    public function AnimeRecord()
    {
        return $this->hasMany(AnimeRecord::class, 'category_id');
    }
}