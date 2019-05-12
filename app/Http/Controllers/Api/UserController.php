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

        $data = User::select("users.name","users.phone","users.token","users.payment_company_id","users.payment_company_id","users.provider_id","users.token","providers.name as provider_name")
            ->join("providers",'providers.id','=','users.provider_id')
            ->where('users.id',$user->id)
            ->first();

        return response([
            'code' => 200,
            'data' => $data
        ],200);
    }



}
