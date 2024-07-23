<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function genre()
    {
        return $this->belongsToMany(Genre::class,'genre_film', 'id_film', 'id_genre');
    }

    public function aktor()
    {
        return $this->belongsToMany(Aktor::class, 'genre_film', 'id_film', 'id_aktor');
    }
}
