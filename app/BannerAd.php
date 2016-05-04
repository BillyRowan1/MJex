<?php

namespace Mjex;

use Illuminate\Database\Eloquent\Model;

class BannerAd extends Model
{
    public function user()
    {
        return $this->belongsTo('Mjex\User');
    }

    public function bannerPlacement()
    {
        return $this->belongsTo('Mjex\BannerPlacement','placement_id','id');
    }
}
