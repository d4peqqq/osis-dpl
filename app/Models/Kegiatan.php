<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kegiatan extends Model
{
    use HasFactory;
    protected $table = 'kegiatan';

    protected $fillable = [
        'title', 'slug', 'body', 'photo', 'date', 'is_published', 'gender',
    ];

    protected $casts = [
        'date' => 'date',
        'is_published' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title) . '-' . Str::random(5);
            }
        });
    }

    public function galeri()
    {
        return $this->hasMany(Galeri::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/default-activity.jpg');
    }
}
