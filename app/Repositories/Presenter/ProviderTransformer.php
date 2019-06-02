<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;

class ProviderTransformer extends TransformerAbstract
{
    public function transform(\App\Models\Provider $provider)
    {
        return [
            'id' => $provider->id,
            'name' => $provider->name,
            'linkman' => $provider->linkman,
            'payment_company_id' => $provider->payment_company_id,
            'phone' => $provider->phone,
            'wechat' => $provider->wechat,
        ];
    }
}
