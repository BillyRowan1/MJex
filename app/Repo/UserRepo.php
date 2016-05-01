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

    public function getRecentGrower($limit = 5)
    {
        $growers = $this->model
                        ->orderBy('created_at','desc')
                        ->where('active',1)
                        ->where('purpose','like','%grower%')
                        ->limit($limit)
                        ->get();

        return $growers;
    }

    public function searchGrower($keyword)
    {
        $searchResults = $this->model->search($keyword)
            ->where('active',1)
            ->orderBy('created_at','desc')
            ->get();

        return $searchResults;
    }
}