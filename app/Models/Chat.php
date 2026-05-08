<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function game(){
        return $this->belongsTo(Game::class);
    }

    public function player(){
        return $this->belongsTo(Player::class);
    }
}
