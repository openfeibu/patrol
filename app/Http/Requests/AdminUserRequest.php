<?php

namespace App\Http\Requests;

use App\Http\Requests\Request as FormRequest;
use Input;
use Illuminate\Validation\Rule;

class AdminUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->model = $this->route('user');
        if (is_null($this->model)) {
            // Determine if the user is authorized to access user module,
            return $this->formRequest->user()->canDo('user.user.view');
        }

        if ($this->isWorkflow()) {
            // Determine if the user is authorized to change status of an entry,
            return $this->can($this->getStatus());
        }

        if ($this->isCreate()) {
            // Determine if the user is authorized to create an entry,
            return $this->can('create');
        }

        if ($this->isUpdate()) {
            // Determine if the user is authorized to update an entry,
            return $this->can('update');
        }

        if ($this->isDelete()) {
            // Determine if the user is authorized to delete an entry,
            return $this->can('delete');
        }
        // Determine if the user is authorized to view the module.
        return $this->can('view');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isCreate()) {
            // validation rule for create request.
            return [

            ];
        }

        if ($this->isStore()) {
            return [
                'name' => 'required|string',
                'email' => 'required|unique:admin_users',
                'password' => 'required|string|min:6',
            ];
        }

        if ($this->isUpdate()) {
            // Validation rule for update request.
            $input = Input::all();
            return [
                'name' => 'required|string',
                'email' => [
                    'filled',
                    Rule::unique('admin_users')->where(function($query)use($input){
                        return $query->where('id','<>',$input['id']);
                    })
                ],
                'password' => 'nullable|string|min:6',
            ];
        }

        // Default validation rule.
        return [

        ];
    }
    public function messages(){
        return [
            'name.require' => '姓名不能为空',
            'email.require' => '邮箱不能为空',
            'email.unique' => '该邮箱已被注册',
            'password.require' => '密码不能为空',
            'password.min' => '密码不能少于六个字符串',
        ];
    }
}
