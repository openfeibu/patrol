<?php

namespace App\Repositories\Presenter;

use App\Repositories\Presenter\FractalPresenter;

class ProviderPresenter extends FractalPresenter
{

    /**
     * Prepare data to present
     *
     * @return \App\Repositories\Eloquent\Presenter\ProviderTransformer
     */
    public function getTransformer()
    {
        return new ProviderTransformer();
    }
}
