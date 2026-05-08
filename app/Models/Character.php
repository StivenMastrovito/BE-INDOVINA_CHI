<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    public function players(){
        $this->belongsTo(Player::class);
    }

    public function pack(){
        $this->belongsTo(Pack::class);
    }
}
