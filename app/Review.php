<?php

namespace Mjex;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    public function seller()
    {
        return $this->belongsTo('Mjex\User');
    }
}
