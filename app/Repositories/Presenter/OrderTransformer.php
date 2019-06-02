<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;
use App\Models\Order;

class OrderTransformer extends TransformerAbstract
{
    public function transform(\App\Models\Order $order)
    {
        $merchant = $order->merchant;
        return [
            'id' => $order->id,
            'order_sn' => $order->order_sn,
            'merchant_id' => $order->merchant_id,
            'user_id' => $order->user_id,
            'user_name' => $order->user_id ? $order->user->name : '未分发',
            'provider_id' => $order->provider_id,
            'provider_name' => $order->provider_id ? $order->provider->name : '未分发',
            'payment_company_id' => $order->payment_company_id,
            'payment_company_name' => $order->payment_company->name,
            'merchant_id' => $order->merchant_id,
            'merchant_name' => $order->merchant->name ,
            'address' => $merchant->address,
            'province' => $merchant->province,
            'city' => $merchant->city,
            'phone' => $merchant->phone,
            'status' => $order->status,
            'status_desc' => $order->status_desc,
            'created_at' => $order->created_at->format('Y-m-d H:i:s') ,
        ];
    }
}
