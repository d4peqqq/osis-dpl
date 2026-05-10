<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'title', 'photo', 'kegiatan_id', 'order', 'gender',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        return asset('storage/' . $this->photo);
    }
}
