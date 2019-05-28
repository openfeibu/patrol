<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;
use App\Models\Order;

class MerchantTransformer extends TransformerAbstract
{
    public function transform(\App\Models\Merchant $merchant)
    {
        $last_order_date = Order::where('merchant_id',$merchant->id)->orderBy('id','desc')->value('created_at');
        return [
            'id' => $merchant->id,
            'name' => $merchant->name,
            'merchant_sn' => $merchant->merchant_sn,
            'model' => $merchant->model,
            'pn' => $merchant->pn,
            'sn' => $merchant->sn,
            'address' => $merchant->address,
            'linkman' => $merchant->linkman,
            'phone' => $merchant->phone,
            'province' => $merchant->province,
            'city' => $merchant->city,
            'payment_company_name' => $merchant->payment_company->name,
            'last_order_date' => $last_order_date ? $last_order_date->format('Y-m-d') : '' ,
        ];
    }
}
