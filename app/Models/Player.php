<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function chats(){
        return $this->hasMany(Chat::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function game(){
        return $this->belongsTo(Game::class);
    }

    public function character(){
        $this->hasOne(Character::class);
    }
}
