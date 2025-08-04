<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Opinion;
use App\Models\Favorite;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_place',
        'description_place',
        'latitude_place',
        'longitude_place',
        'image_place',
        'map_place',
        'distance_place',
        'difficulty_place',
        'estimated_time_place',
    ];

    /**
     * Relation : le lieu appartient à un utilisateur (optionnel selon ton app)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : le lieu a plusieurs opinions (si tu utilises un modèle Opinion séparé)
     */
    public function opinions()
    {
        return $this->hasMany(Opinion::class);
    }

    /**
     * Relation : le lieu a plusieurs favoris (avec commentaires et notes)
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'place_id');
    }
}
