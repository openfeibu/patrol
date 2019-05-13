<?php

namespace App\Http\Controllers\Api;

use Route,Auth,Hash,Input,Log,Image,File;
use Intervention\Image\ImageManager;
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
        $this->user = User::getUser();
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
    public function getWordCard()
    {
        $save_image_path = base_path('storage/uploads').'/'.str_replace('..', '', 'avatar/'.$this->user->id.'/'.'work_card.jpg');
        if(!file_exists($save_image_path))
        {
            $work_card_image_path = base_path('storage/uploads').'/'.str_replace('..', '', 'system/work_card.jpeg');

            $avatar_image_path = base_path('storage/uploads').'/'.str_replace('..', '', $this->user->avatar ?? config('common.default_avatar'));

            $new_avatar_image_path = base_path('storage/uploads').'/'.str_replace('..', '', 'avatar/'.$this->user->id);

            if (!File::isDirectory($new_avatar_image_path)) {
                File::makeDirectory($new_avatar_image_path, 0755, true);
            }

            $avatar_img = Image::make($avatar_image_path)->resize(214,302);

            $avatar_img->save($new_avatar_image_path.'/'.'work_card_avatar.jpg');

            $img = Image::make($work_card_image_path);

            $img->insert($new_avatar_image_path.'/'.'work_card_avatar.jpg', 'top-left', 158, 317 );


            $img->text($this->user->name, 220,660, function($font) {
                $font->file(base_path('storage/uploads/font').'/'.'simsun.ttf');
                $font->size(40);
                $font->color('#000000');
                $font->align('center');
                $font->valign('top');
                //$font->angle(45);
            });

            $img->save($save_image_path);

        }

        $word_card_url = handle_image_url('/avatar/'.$this->user->id.'/'.'work_card.jpg');

        return response([
            'code' => 200,
            'data' => $word_card_url
        ],200);
    }
}
