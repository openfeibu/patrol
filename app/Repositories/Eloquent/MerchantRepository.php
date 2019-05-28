<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\MerchantRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class MerchantRepository extends BaseRepository implements MerchantRepositoryInterface
{
    public function model()
    {
        return config('model.merchant.merchant.model');
    }
}