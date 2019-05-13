<?php

namespace App\Http\Controllers\Api;

use Route,Auth,Hash,Input,Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Api\BaseController;
use App\Models\User;

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

    public function changePassword(Request $request)
    {
        $user = User::getUser();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password'     => 'required|confirmed|min:6',
        ],[
            'old_password.required' => '旧密码不能为空',
            'password.required' => '新密码不能为空',
            'password.confirmed' => '重复新密码不正确',
            'password.min' => '密码最少六位',
        ]);
        if ($validator->fails()) {
            return response([
                'code' => 400,
                'message' => $validator->errors()->first()
            ],400);
        }
        $user->password = User::where('id',$user->id)->value('password');
        if (!Hash::check($request->get('old_password'), $user->password)) {
            return response([
                'code' => 400,
                'message' => '旧密码错误'
            ],400);
        }

        $password = $request->get('password');

        $user->password = bcrypt($password);

        $update = User::where('id',$user->id)->update(['password' => bcrypt($password)]);

        if ($update) {
            return response([
                'code' => 200,
                'message' => '修改成功'
            ],201);
        } else {
            return response([
                'code' => 400,
                'message' => '服务器出错了'
            ],400);
        }
    }
}
