<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function pack(){
        return $this->belongsTo(Pack::class);
    }

    public function chats(){
        return $this->hasMany(Chat::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function players(){
        return $this->hasMany(Player::class);
    }
}
