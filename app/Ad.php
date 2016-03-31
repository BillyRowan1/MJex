<?php

namespace Mjex;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Ad extends Model
{
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'ads.content' => 10,
//            'ads.location' => 10,
            'ads.description' => 10,
            'users.community_name' => 1,
        ],
        'joins' => [
            'users' => ['users.id','ads.user_id'],
        ],
    ];

    public function user()
    {
        return $this->belongsTo('Mjex\User');
    }
}
