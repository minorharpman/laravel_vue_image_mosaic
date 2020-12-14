<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mosaic extends Model
{
    public function imageowner()
    {
        return $this->belongsTo('App\User', 'user_id');

    }
}
