<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['name', 'description', 'latitude', 'longitude', 'image', 'user_id'];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les opinions
    public function opinions()
    {
        return $this->hasMany(Opinion::class);
    }

    // Relation avec les favoris
    public function favorites()
    {
        return $this->hasMany(At_Favorite::class);
    }
}
