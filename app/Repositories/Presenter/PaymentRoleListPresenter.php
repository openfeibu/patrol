<?php

namespace App\Repositories\Presenter;

use App\Repositories\Presenter\FractalPresenter;

class PaymentRoleListPresenter extends FractalPresenter {

    /**
     * Prepare data to present
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PaymentRoleListTransformer();
    }
}