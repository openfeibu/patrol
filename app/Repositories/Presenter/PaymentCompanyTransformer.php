<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;

class PaymentCompanyTransformer extends TransformerAbstract
{
    public function transform(\App\Models\PaymentCompany $payment_company)
    {
        return [
            'id' => $payment_company->id,
            'name' => $payment_company->name,
            'linkman' => $payment_company->linkman,
            'phone' => $payment_company->phone,
            'address' => $payment_company->address,
            'service_tel' => $payment_company->service_tel,
            'auth_file' => $payment_company->auth_file,
            'created_at' => $payment_company->created_at->format('Y-m-d H:i:s')
        ];
    }
}
