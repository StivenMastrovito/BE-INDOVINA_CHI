<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    public function game(){
        return $this->belongsTo(Game::class);
    }

    public function characters(){
        return $this->hasMany(Character::class);
    }

    public function pack_votes(){
        return $this->hasMany(Pack_Vote::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
