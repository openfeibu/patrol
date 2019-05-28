<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\OrderRecordRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class OrderRecordRepository extends BaseRepository implements OrderRecordRepositoryInterface
{
    public function model()
    {
        return config('model.order.order_record.model');
    }
}