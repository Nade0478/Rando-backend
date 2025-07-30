<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class At_Favorite extends Model
{
    protected $table = 'at_favorites';
    protected $fillable = ['user_id', 'place_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
