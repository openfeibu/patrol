<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Payment\ResourceController as BaseController;
use Auth,Storage,Excel;
use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\Provider;
use App\Models\Order;
use App\Repositories\Eloquent\MerchantRepositoryInterface;

class MerchantResourceController extends BaseController
{
    public function __construct(MerchantRepositoryInterface $merchant)
    {
        parent::__construct();
        $this->repository = $merchant;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
    }
    public function index(Request $request)
    {
        $limit = $request->input('limit',config('app.limit'));

        $search = $request->input('search',[]);
        $search_name = isset($search['search_name']) ? $search['search_name'] : '';
        $search_address = isset($search['search_address']) ? $search['search_address'] : '';
        $search_province = isset($search['search_province']) ? $search['search_province'] : '';
        $search_city = isset($search['search_city']) ? $search['search_city'] : '';

        if ($this->response->typeIs('json')) {
            $data = $this->repository;
            if(!empty($search_name))
            {
                $data = $data->where(function ($query) use ($search_name){
                    return $query->where('name','like','%'.$search_name.'%')->orWhere('linkman','like','%'.$search_name.'%')->orWhere('phone','like','%'.$search_name.'%')->orWhere('merchant_sn','like','%'.$search_name.'%');
                });
            }
            if($search_address)
            {
                $data = $data->where(function ($query) use ($search_address){
                    return $query->where('merchants.address','like','%'.$search_address.'%');
                });
            }
            if($search_province)
            {
                $data = $data->where(function ($query) use ($search_province){
                    return $query->where('merchants.province','like','%'.$search_province.'%');
                });
            }
            if($search_city)
            {
                $data = $data->where(function ($query) use ($search_city){
                    return $query->where('merchants.city','like','%'.$search_city.'%');
                });
            }
            $data = $data->setPresenter(\App\Repositories\Presenter\MerchantPresenter::class)
                ->orderBy('id','desc')
                ->getDataTable($limit);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        return $this->response->title(trans('app.admin.panel'))
            ->view('merchant.index')
            ->data(compact('search_address','search_province','search_city','search_name'))
            ->output();

    }
    public function create(Request $request)
    {
        $merchant = $this->repository->newInstance([]);

        return $this->response->title(trans('app.admin.panel'))
            ->view('merchant.create')
            ->data(compact('merchant'))
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();
            $attributes['payment_company_id'] = Auth::user()->payment_company_id;
            $merchant = $this->repository->create($attributes);

            $order_arr = [
                'order_sn' => generate_order_sn(),
                'merchant_id' => $merchant->id,
                'payment_company_id' => Auth::user()->payment_company_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            Order::create($order_arr);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('merchant.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('merchant'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('merchant'))
                ->redirect();
        }
    }
    public function show(Request $request,Merchant $merchant)
    {
        if ($merchant->exists) {
            $view = 'merchant.show';
        } else {
            $view = 'merchant.create';
        }

        return $this->response->title(trans('app.view') . ' ' . trans('merchant.name'))
            ->data(compact('merchant'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,Merchant $merchant)
    {
        try {
            $attributes = $request->all();

            $merchant->update($attributes);

            return $this->response->message(trans('messages.success.updated', ['Module' => trans('merchant.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('merchant/' . $merchant->id))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('merchant/' . $merchant->id))
                ->redirect();
        }
    }
    public function destroy(Request $request,Merchant $merchant)
    {
        try {
            $this->repository->forceDelete([$merchant->id]);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('merchant.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('merchant'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('merchant'))
                ->redirect();
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('merchant.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('merchant'))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('merchant'))
                ->redirect();
        }
    }
    public function createOrder(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $order_arr = [];
            $payment_company_id = Auth::user()->payment_company_id;
            foreach ($ids as $id)
            {
                $order_arr[] = [
                    'order_sn' => generate_order_sn(),
                    'merchant_id' => $id,
                    'payment_company_id' => $payment_company_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
            Order::insert($order_arr);
            return $this->response->message(trans('messages.success.submit'))
                ->status("success")
                ->code(202)
                ->url(guard_url('merchant'))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('merchant'))
                ->redirect();
        }
    }
    public function createOrderNoRecord(Request $request)
    {
        try {
            $payment_company_id = Auth::user()->payment_company_id;
            $record_merchant_ids = Order::where('payment_company_id',$payment_company_id)->groupBy('merchant_id')->pluck('merchant_id');
            $merchant_ids = Merchant::whereNotIn('id',$record_merchant_ids)->pluck('id');
            if(!count($merchant_ids))
            {
                return $this->response->message('未发现需巡检商户')
                    ->status("success")
                    ->code(400)
                    ->url(guard_url('merchant'))
                    ->redirect();
            }
            foreach ($merchant_ids as $id)
            {
                $order_arr[] = [
                    'order_sn' => generate_order_sn(),
                    'merchant_id' => $id,
                    'payment_company_id' => $payment_company_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
            Order::insert($order_arr);
            return $this->response->message('共发起'.count($merchant_ids).'项巡检')
                ->status("success")
                ->code(202)
                ->url(guard_url('merchant'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('merchant'))
                ->redirect();
        }
    }
    public function import(Request $request)
    {
        return $this->response->title(trans('merchant.name'))
            ->view('merchant.import')
            ->output();
    }
    public function submitImport(Request $request)
    {
        $res = app('excel_service')->uploadExcel();
        $count = count($res);
        $success_count = 0;
        $excel_data = [];
        $payment_company_id = Auth::user()->payment_company_id;
        foreach ( $res as $k => $v ) {
            if(trim($v['全称']))
            {
                $success_count++;
                $excel_data[$k] = [
                    'model' => isset($v['机型']) ? trim($v['机型']) : '',
                    'merchant_sn' => isset($v['商户号']) ? trim($v['商户号']) : '',
                    'pn' => isset($v['pn']) ? trim($v['pn']) : '',
                    'sn' => isset($v['sn']) ? trim($v['sn']) : '',
                    'name' => isset($v['全称']) ? trim($v['全称']) : '',
                    'address' => isset($v['经营地址']) ? trim($v['经营地址']) : '',
                    'linkman' => isset($v['联系人']) ? trim($v['联系人']) : '',
                    'phone' => isset($v['联系电话']) ? trim($v['联系电话']) : '',
                    'province' => isset($v['所属省']) ? trim($v['所属省']) : '',
                    'city' => isset($v['所属市']) ? trim($v['所属市']) : '',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'payment_company_id' => $payment_company_id,
                ];
                $merchant = Merchant::create($excel_data[$k]);
                $order_arr = [
                    'order_sn' => generate_order_sn(),
                    'merchant_id' => $merchant->id,
                    'payment_company_id' => $payment_company_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                Order::create($order_arr);
            }
        }
        return $this->response->message("共发现".$count."条数据，排除空行及重复数据后共成功上传".$success_count."条")
            ->status("success")
            ->code(200)
            ->url(guard_url('order_pending_provider'))
            ->redirect();
        /*
        if(!count($excel_data))
        {
            return $this->response->message(trans("messages.excel.not_found_data"))
                ->status("error")
                ->code(400)
                ->url(guard_url('merchant_import'))
                ->redirect();
        }

        $res = Merchant::insert($excel_data);
        if($res)
        {
            return $this->response->message("上传数据成功")
                ->status("success")
                ->code(200)
                ->url(guard_url('merchant'))
                ->redirect();
        }else{
            return $this->response->message("上传数据失败")
                ->status("success")
                ->code(400)
                ->url(guard_url('merchant'))
                ->redirect();
        }
        */
        /*
        return $this->response->title(trans('merchant.name'))
            ->view('merchant.import')
            ->data(compact('excel_data'))
            ->output();
        */
    }
    public function submitImportData(Request $request)
    {
        try {
            $excel_data = $request->all();

            $models = $excel_data['model'];
            $data = [];
            foreach($models as $key => $model)
            {
                $data[$key] = [
                    'model' => isset($excel_data['model'][$key]) ? $excel_data['model'][$key] : '',
                    'merchant_sn' => isset($excel_data['merchant_sn'][$key]) ? $excel_data['merchant_sn'][$key] : '',
                    'pn' => isset($excel_data['pn'][$key]) ? $excel_data['pn'][$key] : '',
                    'sn' => isset($excel_data['sn'][$key]) ? $excel_data['sn'][$key] : '',
                    'name' => isset($excel_data['name'][$key]) ? $excel_data['name'][$key] : '',
                    'address' => isset($excel_data['address'][$key]) ? $excel_data['address'][$key] : '',
                    'linkman' => isset($excel_data['linkman'][$key]) ? $excel_data['linkman'][$key] : '',
                    'phone' => isset($excel_data['phone'][$key]) ? $excel_data['phone'][$key] : '',
                    'province' => isset($excel_data['province'][$key]) ? $excel_data['province'][$key] : '',
                    'city' => isset($excel_data['city'][$key]) ? $excel_data['city'][$key] : '',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'payment_company_id' => Auth::user()->payment_company_id,
                ];
            }

            $res = Merchant::insert($data);
            if($res)
            {
                return $this->response->message("上传数据成功")
                    ->status("success")
                    ->code(200)
                    ->url(guard_url('merchant'))
                    ->redirect();
            }else{
                return $this->response->message("上传数据失败")
                    ->status("error")
                    ->code(200)
                    ->url(guard_url('merchant'))
                    ->redirect();
            }
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('merchant'))
                ->redirect();
        }
    }
}
