<?php

namespace Mjex\Repo;

use Illuminate\Support\Facades\DB;
use Mjex\User;

class UserRepo{
    protected $table = 'users';
    public function __construct(User $model)
    {
        $this->model = $model;
    }
    public function getAllZipcode()
    {
        $zipcodes = DB::table($this->table)->pluck('zipcode','country');
        if(count($zipcodes)>0) {
            $zipcodes = array_unique($zipcodes);
        }

        return $zipcodes;
    }
}