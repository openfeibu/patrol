<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\BaseModel;
use App\Traits\Database\Slugger;
use App\Traits\Filer\Filer;
use App\Traits\Hashids\Hashids;
use App\Traits\Trans\Translatable;

class OrderRecord extends BaseModel
{
    use Filer, Hashids, Slugger, Translatable, LogsActivity;

    /**
     * Configuartion for the model.
     *
     * @var array
     */
    protected $config = 'model.order.order_record';

    protected $appends = ['merchant_result_desc','status_desc'];       // 表里没有的字段

    public function getMerchantResultDescAttribute()
    {
        $merchant_result = $this->attributes['merchant_result'];
        return trans('order_record.merchant_result.'.$merchant_result);
    }

    public function getStatusDescAttribute()
    {
        $status = $this->attributes['status'];
        return trans('order.status.'.$status);
    }
}