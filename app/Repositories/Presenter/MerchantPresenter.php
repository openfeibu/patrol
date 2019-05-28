<?php

namespace App\Repositories\Presenter;

use App\Repositories\Presenter\FractalPresenter;

class MerchantPresenter extends FractalPresenter
{

    /**
     * Prepare data to present
     *
     * @return \App\Repositories\Eloquent\Presenter\MerchantTransformer
     */
    public function getTransformer()
    {
        return new MerchantTransformer();
    }
}
