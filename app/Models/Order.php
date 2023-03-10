<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\BaseModel;
use App\Traits\Database\Slugger;
use App\Traits\Filer\Filer;
use App\Traits\Hashids\Hashids;
use App\Traits\Trans\Translatable;

class Order extends BaseModel
{
    use Filer, Hashids, Slugger, Translatable, LogsActivity;

    /**
     * Configuartion for the model.
     *
     * @var array
     */
    protected $config = 'model.order.order';

    protected $appends = ['status_desc'];       // 表里没有的字段

    public function getStatusDescAttribute()
    {
        $status = $this->attributes['status'];
        return trans('order.status.'.$status);
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function provider()
    {
        return $this->belongsTo('App\Models\Provider');
    }
    public function payment_company()
    {
        return $this->belongsTo('App\Models\PaymentCompany');
    }
    public function merchant()
    {
        return $this->belongsTo('App\Models\Merchant');
    }
}