<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pack_Vote extends Model
{
    protected $table = 'pack_votes';

    public function pack(){
        return $this->belongsTo(Pack::class);
    }
}
