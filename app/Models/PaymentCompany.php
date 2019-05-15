<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\BaseModel;
use App\Traits\Database\Slugger;
use App\Traits\Filer\Filer;
use App\Traits\Hashids\Hashids;
use App\Traits\Trans\Translatable;

class PaymentCompany extends BaseModel
{
    use Filer, Hashids, Slugger, Translatable, LogsActivity;

    /**
     * Configuartion for the model.
     *
     * @var array
     */
    protected $config = 'model.payment_company.payment_company';


    public function getAuthFileAttribute($auth_file)
    {
        return $auth_file ? url('image/original'.$auth_file) : url('image/original'.config('common.auth_file'));
    }
}