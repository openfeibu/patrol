<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\OrderRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function model()
    {
        return config('model.order.order.model');
    }
}