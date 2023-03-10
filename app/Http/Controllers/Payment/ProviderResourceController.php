<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Payment\ResourceController as BaseController;
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

        if ($this->response->typeIs('json')) {
            $data = $this->repository
                ->where(['payment_company_id' => Auth::user()->payment_company_id])
                ->setPresenter(\App\Repositories\Presenter\ProviderPresenter::class)
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
            $attributes['payment_company_id'] = Auth::user()->payment_company_id;
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
        $payment_company_id = Auth::user()->payment_company_id;

        foreach ( $res as $k => $v ) {
            $excel_data[$k] = [
                'name' => isset($v['???????????????']) ? $v['???????????????'] : '',
                'linkman' => isset($v['??????????????????']) ? $v['??????????????????'] : '',
                'phone' => isset($v['?????????????????????']) ? $v['?????????????????????'] : '',
                'wechat' => isset($v['????????????????????????']) ? $v['????????????????????????'] : '',
                'payment_company_id' => $payment_company_id,
            ];
        }

        if(!count($excel_data))
        {
            return $this->response->message(trans("messages.excel.not_found_data"))
                ->status("success")
                ->code(400)
                ->url(guard_url('provider_import'))
                ->redirect();
        }
        $res = Provider::insert($excel_data);
        if($res)
        {
            return $this->response->message("??????????????????")
                ->status("success")
                ->code(200)
                ->url(guard_url('provider'))
                ->redirect();
        }else{
            return $this->response->message("??????????????????")
                ->status("success")
                ->code(400)
                ->url(guard_url('provider'))
                ->redirect();
        }

    }

}
