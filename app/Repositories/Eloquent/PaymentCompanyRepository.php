<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\PaymentCompanyRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class PaymentCompanyRepository extends BaseRepository implements PaymentCompanyRepositoryInterface
{
    public function model()
    {
        return config('model.payment_company.payment_company.model');
    }
}