<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;
use Hashids;

class UserTransformer extends TransformerAbstract
{
    public function transform(\App\Models\User $user)
    {
        return [
            //'id'                => $user->getRouteKey(),
            'id' => $user->id,
            'name'              => $user->name,
            'email'             => $user->email,
            'api_token'         => $user->api_token,
            'remember_token'    => $user->remember_token,
            'phone'             => $user->phone,
            'avatar_url'        => $user->avatar_url,
            'wechat'            => $user->wechat,
            'payment_company_name' => $user->payment_company->name,
            'provider_name'     => $user->provider->name,
            'created_at'        => format_date($user->created_at),
            'updated_at'        => format_date($user->updated_at),
        ];
    }
}