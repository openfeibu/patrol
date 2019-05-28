<?php

namespace App\Repositories\Presenter;

use App\Repositories\Presenter\FractalPresenter;

class ProviderUserPresenter extends FractalPresenter {

    /**
     * Prepare data to present
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProviderUserTransformer();
    }
}