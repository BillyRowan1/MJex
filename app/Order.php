<?php

namespace Mjex;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    public function seeker()
    {
        return $this->belongsTo('Mjex\User','seeker_id');
    }

    public function seller()
    {
        return $this->belongsTo('Mjex\User','seller_id');
    }
}
