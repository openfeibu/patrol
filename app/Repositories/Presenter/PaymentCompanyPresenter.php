<?php

namespace App\Repositories\Presenter;

use App\Repositories\Presenter\FractalPresenter;

class PaymentCompanyPresenter extends FractalPresenter
{

    /**
     * Prepare data to present
     *
     * @return \App\Repositories\Eloquent\Presenter\PaymentCompanyTransformer
     */
    public function getTransformer()
    {
        return new PaymentCompanyTransformer();
    }
}
