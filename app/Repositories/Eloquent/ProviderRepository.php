<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\ProviderRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class ProviderRepository extends BaseRepository implements ProviderRepositoryInterface
{
    public function model()
    {
        return config('model.provider.provider.model');
    }
}