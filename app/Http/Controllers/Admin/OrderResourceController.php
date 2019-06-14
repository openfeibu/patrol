<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use App\Models\PaymentCompany;
use Auth,Excel;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Provider;
use App\Models\Merchant;
use App\Models\OrderLog;
use App\Models\OrderRecord;
use App\Repositories\Eloquent\OrderRecordRepositoryInterface;
use App\Repositories\Eloquent\OrderRepositoryInterface;
use App\Services\ExportPdfService;

class OrderResourceController extends BaseController
{
    public function __construct(OrderRepositoryInterface $order,OrderRecordRepositoryInterface $order_record)
    {
        parent::__construct();
        $this->repository = $order;
        $this->order_record_repository = $order_record;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
    }
    public function orderPendingProvider(Request $request)
    {
        return $this->order_list($request,'pending_provider');
    }
    public function orderPendingUser(Request $request)
    {
        return $this->order_list($request,'pending_user');
    }
    public function orderWorking(Request $request)
    {
        return $this->order_list($request,'working');
    }
    public function orderFinish(Request $request)
    {
        return $this->order_list($request,'finish');
    }
    public function orderReturn(Request $request)
    {
        return $this->order_list($request,'return');
    }
    public function orderPass(Request $request)
    {
        return $this->order_list($request,'pass');
    }
    public function order_list(Request $request,$status)
    {
        $limit = $request->input('limit',config('app.limit'));

        $search = $request->input('search',[]);
        $payment_company_id = isset($search['payment_company_id']) ? $search['payment_company_id'] : 0;
        $provider_id = isset($search['provider_id']) ? $search['provider_id'] : 0;
        $search_name = isset($search['search_name']) ? $search['search_name'] : '';
        $search_address = isset($search['search_address']) ? $search['search_address'] : '';
        $search_province = isset($search['search_province']) ? $search['search_province'] : '';
        $search_city = isset($search['search_city']) ? $search['search_city'] : '';
        $search_merchant_name = isset($search['search_merchant_name']) ? $search['search_merchant_name'] : '';

        if ($this->response->typeIs('json')) {
            $data = $this->repository->join('merchants','merchants.id','=','orders.merchant_id')
                ->where('orders.status',$status);
            if($payment_company_id)
            {
                $data = $data->where('orders.payment_company_id',$payment_company_id);
            }
            if($provider_id)
            {
                $data = $data->where('orders.provider_id',$provider_id);
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
            if($search_merchant_name)
            {
                $data = $data->where(function ($query) use ($search_merchant_name){
                    return $query->where('merchants.name','like','%'.$search_merchant_name.'%');
                });
            }
            if($search_name)
            {
                $data = $data->where(function ($query) use ($search_name){
                    return $query->where('merchants.address','like','%'.$search_name.'%')->orWhere('merchants.province','like','%'.$search_name.'%')->orWhere('merchants.city','like','%'.$search_name.'%')->orWhere('merchants.name','like','%'.$search_name.'%');
                });
            }
            $data = $data
                ->setPresenter(\App\Repositories\Presenter\OrderPresenter::class)
                ->orderBy('orders.id','desc')
                ->getDataTable($limit,['orders.*']);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        $providers = Provider::orderBy('id','desc')->get();
        $payment_companies = PaymentCompany::orderBy('id','desc')->get();
        return $this->response->title(trans('app.admin.panel'))
            ->view('order.'.$status)
            ->data(compact('providers','payment_companies','payment_company_id','provider_id','search_address','search_province','search_city','search_merchant_name','search_name'))
            ->output();
    }
    public function index(Request $request)
    {
        $limit = $request->input('limit',config('app.limit'));

        if ($this->response->typeIs('json')) {
            $data = $this->repository
                ->setPresenter(\App\Repositories\Presenter\OrderPresenter::class)
                ->orderBy('id','desc')
                ->getDataTable($limit);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        return $this->response->title(trans('app.admin.panel'))
            ->view('order.index')
            ->output();

    }
    public function create(Request $request)
    {
        $order = $this->repository->newInstance([]);

        return $this->response->title(trans('app.admin.panel'))
            ->view('order.create')
            ->data(compact('order'))
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();
            $attributes['payment_company_id'] = Auth::user()->payment_company_id;
            $order = $this->repository->create($attributes);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('order.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('order'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('order'))
                ->redirect();
        }
    }
    public function show(Request $request,Order $order)
    {
        if ($order->exists) {
            $view = 'order.show';
        } else {
            $view = 'order.create';
        }

        $merchant = $order->merchant;

        $order_record = $this->order_record_repository->getOrderRecordByOrderId($order->id);

        $order_logs = OrderLog::where('order_id',$order->id)->where('type','note')->orderBy('id','desc')->get();

        return $this->response->title(trans('app.view') . ' ' . trans('order.name'))
            ->data(compact('order','order_record','merchant','order_logs'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,Order $order)
    {
        try {
            $attributes = $request->all();

            $order->update($attributes);

            return $this->response->message(trans('messages.success.updated', ['Module' => trans('order.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('order/' . $order->id))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('order/' . $order->id))
                ->redirect();
        }
    }
    public function destroy(Request $request,Order $order)
    {
        try {
            $this->repository->forceDelete([$order->id]);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('order.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('order'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('order'))
                ->redirect();
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('order.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('order'))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('order'))
                ->redirect();
        }
    }
    public function pushProvider(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $provider_id = $data['provider_id'];

            Order::whereIn('id',$ids)->update([
                'provider_id' =>  $provider_id,
                'status' => 'pending_user',
            ]);

            return $this->response->message('分发成功')
                ->status("success")
                ->code(202)
                ->url(guard_url('order'))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('order'))
                ->redirect();
        }
    }
    public function ReturnOrder(Request $request)
    {
        try {
            $data = $request->all();
            $id = $data['id'];
            $return_content = $data['return_content'];

            Order::where('id',$id)->update([
                'status' => 'return',
            ]);
            $order_record = OrderRecord::where('order_id',$id)->orderBy('id','desc')->first();
            OrderRecord::where('id',$order_record->id)->update([
                'status' => 'return',
                'return_content' => $return_content,
            ]);
            return $this->response->message('退单成功')
                ->status("success")
                ->code(202)
                ->url(guard_url('order_finish'))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('order_finish'))
                ->redirect();
        }
    }
    public function PassOrder(Request $request)
    {
        try {
            $data = $request->all();
            $id = $data['id'];

            $order_record = OrderRecord::where('order_id',$id)->orderBy('id','desc')->first();
            Order::where('id',$id)->update([
                'status' => 'pass',
            ]);

            OrderRecord::where('id',$order_record->id)->update([
                'status' => 'pass',
            ]);

            return $this->response->message('审核成功')
                ->status("success")
                ->code(202)
                ->url(guard_url('order_finish'))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('order_finish'))
                ->redirect();
        }
    }
    public function noteOrder(Request $request)
    {
        try {
            $data = $request->all();
            $id = $data['id'];
            unset($data['id']);
            $data['order_id'] = $id;
            $data['admin_id'] = Auth::user()->id;
            $data['admin_type'] = 'admin';
            $data['name'] = Auth::user()->name;

            OrderLog::create($data);

            return $this->response->message('备注成功')
                ->status("success")
                ->code(202)
                ->url(guard_url('order_finish'))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('order_finish'))
                ->redirect();
        }
    }
    public function exportOrder(Request $request)
    {

        $search = $request->input('search',[]);
        $handle_fields = $request->input('fields',[]);
        $type = $request->input('type','encrypt');
        $payment_company_id = isset($search['payment_company_id']) ? $search['payment_company_id'] : 0;
        $provider_id = isset($search['provider_id']) ? $search['provider_id'] : 0;
        $search_address = isset($search['search_address']) ? $search['search_address'] : '';
        $search_province = isset($search['search_province']) ? $search['search_province'] : '';
        $search_city = isset($search['search_city']) ? $search['search_city'] : '';
        $search_merchant_name = isset($search['search_merchant_name']) ? $search['search_merchant_name'] : '';

        $data = $this->repository->join('merchants','merchants.id','=','orders.merchant_id')
            ->where('orders.status','pass');
        if($payment_company_id)
        {
            $data = $data->where('orders.payment_company_id',$payment_company_id);
        }
        if($provider_id)
        {
            $data = $data->where('orders.provider_id',$provider_id);
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
        if($search_merchant_name)
        {
            $data = $data->where(function ($query) use ($search_merchant_name){
                return $query->where('merchants.name','like','%'.$search_merchant_name.'%');
            });
        }
        $data = $data->orderBy('orders.id','desc')->all(['orders.id as order_id','merchants.*']);

        $export_fields = config('model.order.order_record.excel_fields');

        $export_data = [];
        $export_data[0] = ["商户名称","商户编号"];
        $field_i = 2;
        foreach ($export_fields as $key => $field)
        {
            if(in_array($field,$handle_fields)) {
                if ($type == 'encrypt') {
                    $export_data[0][$field_i] = trans('order_record.label.'.$field);
                    $field_i++;
                }
            }else{
                $export_data[0][$field_i] = trans('order_record.label.'.$field);
                $field_i++;
            }

        }
        $excel_without_image_fields = config('model.order.order_record.excel_without_image_fields');
        foreach ($excel_without_image_fields as $key => $field)
        {
            $export_data[0][$field_i] = trans('order_record.label.'.$field);
            $field_i++;
        }
        $i = 1;
        foreach ($data as $key => $val)
        {
            $order_record = $this->order_record_repository->getOrderRecordByOrderId($val['order_id']);
            $export_data[$i] = [$val['name'],$val['merchant_sn']."\t"];
            $field_i = 2;
            foreach($export_fields as $key => $field)
            {
                if(in_array($field,$handle_fields))
                {
                    if($type == 'encrypt')
                    {
                        $export_data[$i][$field_i] = '****';
                        $field_i++;
                    }
                }else{
                    $export_data[$i][$field_i] = $order_record[$field];
                    $field_i++;
                }

            }
            foreach ($excel_without_image_fields as $key => $field)
            {
                if(strpos($field,'_content') === false && strpos($field,'is_') !== false || $field == 'cashier_mobility' || $field == 'cashier_band_card_operation_skills')
                {
                    $export_data[$i][$field_i] = is_status_desc($order_record[$field]);
                }else{
                    $export_data[$i][$field_i] = $order_record[$field];
                }
                $field_i++;
            }
            $i++;
        }

        Excel::create('巡检单'.date("YmdHis"),function($excel) use ($export_data){
            $excel->sheet('巡检单', function($sheet) use ($export_data){
                $sheet->rows($export_data);
            });
        })->store('xls')->export('xls');


    }
    public function exportOrderPdf(Request $request)
    {
        $search = $request->input('search',[]);
        $handle_fields = $request->input('fields',[]);
        $type = $request->input('type','encrypt');
        $payment_company_id = isset($search['payment_company_id']) ? $search['payment_company_id'] : 0;
        $provider_id = isset($search['provider_id']) ? $search['provider_id'] : 0;
        $search_address = isset($search['search_address']) ? $search['search_address'] : '';
        $search_province = isset($search['search_province']) ? $search['search_province'] : '';
        $search_city = isset($search['search_city']) ? $search['search_city'] : '';
        $search_merchant_name = isset($search['search_merchant_name']) ? $search['search_merchant_name'] : '';

        $data = $this->repository->join('merchants','merchants.id','=','orders.merchant_id')
            ->where('orders.status','pass');
        if($payment_company_id)
        {
            $data = $data->where('orders.payment_company_id',$payment_company_id);
        }
        if($provider_id)
        {
            $data = $data->where('orders.provider_id',$provider_id);
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
        if($search_merchant_name)
        {
            $data = $data->where(function ($query) use ($search_merchant_name){
                return $query->where('merchants.name','like','%'.$search_merchant_name.'%');
            });
        }
        $orders = $data->orderBy('orders.id','desc')->all(['orders.*']);
        $export_pdf = new ExportPdfService();
        return $export_pdf->export_orders($orders);
    }
}
