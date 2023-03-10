<?php

namespace App\Http\Requests;

use App\Http\Requests\Request as FormRequest;
use Input;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
                'phone' => 'required|unique:users',
                'password' => 'required|string|min:6',
            ];
        }
        if ($this->isUpdate()) {
            $input = Input::all();
            return [
                'phone' => [
                    'filled',
                    Rule::unique('users')->where(function($query)use($input){
                        return $query->where('id','<>',$input['id']);
                    })
                ],
                'password' => 'nullable|string|min:6',
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
