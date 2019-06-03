<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Provider\ResourceController as BaseController;
use Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Provider;
use App\Models\Merchant;
use App\Models\OrderRecord;
use App\Models\User;
use App\Models\PaymentCompany;
use App\Repositories\Eloquent\OrderRepositoryInterface;

class OrderResourceController extends BaseController
{
    public function __construct(OrderRepositoryInterface $order)
    {
        parent::__construct();
        $this->repository = $order;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
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
        $search_name = isset($search['search_name']) ? $search['search_name'] : '';
        $search_address = isset($search['search_address']) ? $search['search_address'] : '';
        $search_province = isset($search['search_province']) ? $search['search_province'] : '';
        $search_city = isset($search['search_city']) ? $search['search_city'] : '';
        $search_merchant_name = isset($search['search_merchant_name']) ? $search['search_merchant_name'] : '';

        if ($this->response->typeIs('json')) {
            $data = $this->repository->join('merchants','merchants.id','=','orders.merchant_id')
                ->where('orders.status',$status)
                ->where('orders.provider_id',Auth::user()->provider_id);
            if($payment_company_id)
            {
                $data = $data->where('orders.payment_company_id',$payment_company_id);
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
        $payment_companies = PaymentCompany::orderBy('id','desc')->get();
        $users = User::where('provider_id', Auth::user()->provider_id)->orderBy('id','desc')->get();

        return $this->response->title(trans('app.admin.panel'))
            ->view('order.'.$status)
            ->data(compact('providers','payment_companies','users','payment_company_id','provider_id','search_address','search_province','search_city','search_merchant_name','search_name'))
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

        $order_record_fields = config('model.order.order_record.fillable');

        $order_record = OrderRecord::select("*",'id as order_record_id')->where('order_id',$order->id)->orderBy('id','desc')->first();

        if($order_record)
        {
            $order_record = $order_record->toArray();
            foreach ($order_record_fields as $key => $field)
            {
                if(strpos($field,'image') !== false)
                {

                    if($order_record[$field])
                    {
                        $order_record[$field.'_path'] = explode(',',$order_record[$field]);
                        $order_record[$field.'_thumb'] = handle_images_thumb('order',explode(',',$order_record[$field]));
                        $order_record[$field] = handle_images(explode(',',$order_record[$field]));

                    }else{
                        $order_record[$field.'_path'] = [];
                        $order_record[$field.'_thumb'] = [];
                        $order_record[$field] = [];
                    }
                }
            }
        }

        return $this->response->title(trans('app.view') . ' ' . trans('order.name'))
            ->data(compact('order','order_record','merchant'))
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

    }
    public function destroyAll(Request $request)
    {

    }
    public function pushUser(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $user_id = $data['user_id'];

            Order::whereIn('id',$ids)->update([
                'user_id' =>  $user_id,
                'status' => 'working',
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
}
