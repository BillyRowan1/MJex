<?php

namespace Mjex;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;
use Nicolaslopezj\Searchable\SearchableTrait;
use HappyDemon\UsrLastly\LastSeenTrait as LastSeen;

class User extends Authenticatable implements BillableContract
{
    use Billable, SearchableTrait, LastSeen;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'users.community_name' => 1,
//            'users.anonymous_email' => 2,
//            'users.email' => 3,
        ],
    ];

    protected $dates = ['trial_ends_at', 'subscription_ends_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function reviews()
    {
        return $this->hasMany('Mjex\Review');
    }
}
