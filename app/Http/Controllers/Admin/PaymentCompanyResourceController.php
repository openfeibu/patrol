<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use Auth;
use Illuminate\Http\Request;
use App\Models\PaymentCompany;
use App\Repositories\Eloquent\PaymentCompanyRepositoryInterface;

class PaymentCompanyResourceController extends BaseController
{
    public function __construct(PaymentCompanyRepositoryInterface $payment_company)
    {
        parent::__construct();
        $this->repository = $payment_company;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
    }
    public function index(Request $request)
    {
        $limit = $request->input('limit',config('app.limit'));

        if ($this->response->typeIs('json')) {
            $data = $this->repository
                ->setPresenter(\App\Repositories\Presenter\PaymentCompanyPresenter::class)
                ->orderBy('id','desc')
                ->getDataTable($limit);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        return $this->response->title(trans('app.admin.panel'))
            ->view('payment_company.index')
            ->output();

    }
    public function create(Request $request)
    {
        $payment_company = $this->repository->newInstance([]);

        return $this->response->title(trans('app.admin.panel'))
            ->view('payment_company.create')
            ->data(compact('payment_company'))
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();

            $payment_company = $this->repository->create($attributes);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('payment_company.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('payment_company'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('payment_company'))
                ->redirect();
        }
    }
    public function show(Request $request,PaymentCompany $payment_company)
    {
        if ($payment_company->exists) {
            $view = 'payment_company.show';
        } else {
            $view = 'payment_company.create';
        }

        return $this->response->title(trans('app.view') . ' ' . trans('payment_company.name'))
            ->data(compact('payment_company'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,PaymentCompany $payment_company)
    {
        try {
            $attributes = $request->all();

            $payment_company->update($attributes);

            return $this->response->message(trans('messages.success.updated', ['Module' => trans('payment_company.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('payment_company/' . $payment_company->id))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('payment_company/' . $payment_company->id))
                ->redirect();
        }
    }
    public function destroy(Request $request,PaymentCompany $payment_company)
    {
        try {
            $this->repository->forceDelete([$payment_company->id]);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('payment_company.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('payment_company'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('payment_company'))
                ->redirect();
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('payment_company.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('payment_company'))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('payment_company'))
                ->redirect();
        }
    }
    public function import(Request $request)
    {
        return $this->response->title(trans('payment_company.name'))
            ->view('payment_company.import')
            ->output();
    }
    public function submitImport(Request $request)
    {
        $res = app('excel_service')->uploadExcel();

        $excel_data = [];
        $payment_company_id = Auth::user()->payment_company_id;

        foreach ( $res as $k => $v ) {
            $excel_data[$k] = [
                'name' => isset($v['服务商名称']) ? $v['服务商名称'] : '',
                'linkman' => isset($v['服务商负责人']) ? $v['服务商负责人'] : '',
                'phone' => isset($v['服务商联系电话']) ? $v['服务商联系电话'] : '',
                'wechat' => isset($v['服务商负责人微信']) ? $v['服务商负责人微信'] : '',
                'payment_company_id' => $payment_company_id,
            ];
        }

        if(!count($excel_data))
        {
            return $this->response->message(trans("messages.excel.not_found_data"))
                ->status("success")
                ->code(400)
                ->url(guard_url('payment_company_import'))
                ->redirect();
        }
        $res = PaymentCompany::insert($excel_data);
        if($res)
        {
            return $this->response->message("上传数据成功")
                ->status("success")
                ->code(200)
                ->url(guard_url('payment_company'))
                ->redirect();
        }else{
            return $this->response->message("上传数据失败")
                ->status("success")
                ->code(400)
                ->url(guard_url('payment_company'))
                ->redirect();
        }

    }

}
