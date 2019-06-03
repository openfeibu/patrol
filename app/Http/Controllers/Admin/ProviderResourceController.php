<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use App\Models\ProviderRole;
use App\Models\ProviderUser;
use Auth;
use Illuminate\Http\Request;
use App\Models\Provider;
use App\Repositories\Eloquent\ProviderRepositoryInterface;

class ProviderResourceController extends BaseController
{
    public function __construct(ProviderRepositoryInterface $provider)
    {
        parent::__construct();
        $this->repository = $provider;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
    }
    public function index(Request $request)
    {
        $limit = $request->input('limit',config('app.limit'));

        $search = $request->input('search',[]);
        $search_name = isset($search['search_name']) ? $search['search_name'] : '';

        if ($this->response->typeIs('json')) {
            $data = $this->repository;
            if(!empty($search_name))
            {
                $data = $data->where(function ($query) use ($search_name){
                    return $query->where('name','like','%'.$search_name.'%')->orWhere('linkman','like','%'.$search_name.'%')->orWhere('phone','like','%'.$search_name.'%');
                });
            }
            $data = $data->setPresenter(\App\Repositories\Presenter\ProviderPresenter::class)
                ->orderBy('id','desc')
                ->getDataTable($limit);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        return $this->response->title(trans('app.admin.panel'))
            ->view('provider.index')
            ->output();

    }
    public function create(Request $request)
    {
        $provider = $this->repository->newInstance([]);

        return $this->response->title(trans('app.admin.panel'))
            ->view('provider.create')
            ->data(compact('provider'))
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();
            $provider = $this->repository->create($attributes);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('provider.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('provider'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('provider'))
                ->redirect();
        }
    }
    public function show(Request $request,Provider $provider)
    {
        if ($provider->exists) {
            $view = 'provider.show';
        } else {
            $view = 'provider.create';
        }

        return $this->response->title(trans('app.view') . ' ' . trans('provider.name'))
            ->data(compact('provider'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,Provider $provider)
    {
        try {
            $attributes = $request->all();

            $provider->update($attributes);

            return $this->response->message(trans('messages.success.updated', ['Module' => trans('provider.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('provider/' . $provider->id))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('provider/' . $provider->id))
                ->redirect();
        }
    }
    public function destroy(Request $request,Provider $provider)
    {
        try {
            $this->repository->forceDelete([$provider->id]);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('provider.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('provider'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('provider'))
                ->redirect();
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('provider.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('provider'))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('provider'))
                ->redirect();
        }
    }
    public function import(Request $request)
    {
        return $this->response->title(trans('provider.name'))
            ->view('provider.import')
            ->output();
    }
    public function submitImport(Request $request)
    {
        $res = app('excel_service')->uploadExcel();

        $excel_data = [];

        foreach ( $res as $k => $v ) {
            $excel_data[$k] = [
                'name' => isset($v['服务商名称']) ? trim($v['服务商名称']) : '',
                'linkman' => isset($v['服务商负责人']) ? trim($v['服务商负责人']) : '',
                'phone' => isset($v['服务商联系电话']) ? trim($v['服务商联系电话']) : '',
                'wechat' => isset($v['服务商负责人微信']) ? trim($v['服务商负责人微信']) : '',
            ];
            $provider = Provider::create($excel_data[$k]);
            $phone = ProviderUser::where('phone',$excel_data[$k]['phone'])->value('id');
            if(!$phone && $provider)
            {
                $provider_user = ProviderUser::create([
                    'phone' => $excel_data[$k]['phone'],
                    'name' => $excel_data[$k]['name'],
                    'provider_id' => $provider->id,
                    'password' => '123456'
                ]);
                $role_id = ProviderRole::where('slug','superuser')->value('id');
                $provider_user->roles()->sync([$role_id]);
            }
        }


        return $this->response->message("上传数据成功")
            ->status("success")
            ->code(200)
            ->url(guard_url('provider'))
            ->redirect();

    }

}
