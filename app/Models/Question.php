<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function game(){
        $this->belongsTo(Game::class);
    }
    
    public function player(){
        $this->belongsTo(Player::class);
    }
}
