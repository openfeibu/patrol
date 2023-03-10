<?php

namespace App\Http\Controllers\Provider;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs,  ValidatesRequests;
    /**
     * @var store response object
     */
    public $response;

    /**
     * @var store repository object
     */
    public $repository;

    public function __construct()
    {
        set_route_guard('web','provider','provider');
    }

}