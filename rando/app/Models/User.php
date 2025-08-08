<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use App\Models\Place;
use App\Models\Favorite;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            //'password' => 'hashed',
        ];
    }

    /**
     * Lieux créés par l'utilisateur
     */
    public function places()
    {
        return $this->hasMany(Place::class);
    }

    /**
     * Favoris de l'utilisateur
     */
    public function favorites()
    {
        return $this->belongsToMany(Favorite::class);
    }

    /**
     * JWT : identifiant unique
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * JWT : claims personnalisés
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
