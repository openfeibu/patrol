<?php

namespace App\Http\Requests;

use App\Http\Requests\Request as FormRequest;

class PaymentUserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        if ($this->isStore()) {
            return [
                'phone' => 'required|unique:provider_users',
                'password' => 'required|string|min:6',
            ];
        }
    }

    public function messages(){
        return [
            'phone.unique' => '该手机号码已被注册',
            'password.require' => '密码不能为空',
            'password.min' => '密码不能少于六个字符串',
        ];
    }
}
