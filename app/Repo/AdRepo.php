<?php

namespace Mjex\Repo;

use Mjex\Ad;

class AdRepo{
    public function __construct(Ad $ad)
    {
        $this->model = $ad;
    }
    public function getAllZipcode()
    {
    }
}