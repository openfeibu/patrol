<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Eloquent\PageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Banner;
use App\Models\User;
use Tymon\JWTAuth\JWTAuth;

use Log;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.api');
    }
    public function getUser(Request $request)
    {
        $user = User::getUser();

        return response([
            'code' => 200,
            'data' => $user
        ],200);
    }



}
