<?php

namespace Mjex;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable implements BillableContract
{
    use Billable, SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'users.community_name' => 1,
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
