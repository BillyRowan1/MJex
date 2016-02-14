<?php

namespace Mjex;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    public function user()
    {
        return $this->belongsTo('Mjex\User');
    }
}
