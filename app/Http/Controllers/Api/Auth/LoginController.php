<?php

namespace App\Http\Controllers\Api\Auth;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use App\Models\User;
use App\Http\Controllers\Api\BaseController;

class LoginController extends BaseController
{
    public function login(Request $request)
    {
        // 规则
        $rules = [
            'phone' => 'required|string',
            'password' => 'required|string|min:6',
        ];
        $messages = [
            'phone.require' => '账号不能为空',
            'password.require' => '密码不能为空',
            'password.min' => '密码不能少于六个字符串',
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {

            return response()->json([
                'code' => '400',
                "message" =>$validator->errors()->first()
            ],400);
        }

        $token = Auth::guard('user.api')->attempt($request->all());

        if(!$token)
        {
            return response()->json([
                'code' => '400',
                "message" => "账号或密码错误"
            ],400);
        }
        $user = User::getUserByPhone($request->phone);

        User::where('phone',$request->phone)->update(['token' => $token]);

        $user->token = $token;

        return response()->json([
            'code' => '200',
            "message" => "登录成功",
            'data' => $user
         ],201);

        /*
        //Auth::guard('user.api')->useResponsable(false);

        $token = Auth::guard('user.api')->attempt($request->all());

        if($token)
        {
            return response(['code' => '200',"message" => "登录成功",'token' => 'bearer ' . $token], 201);
        }


        return response()->json([
            'code' => '400',
            "message" => "账号或密码错误"
        ],400);
        */
    }
}
