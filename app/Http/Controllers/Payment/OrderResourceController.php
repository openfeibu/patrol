<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Payment\ResourceController as BaseController;
use Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Provider;
use App\Models\Merchant;
use App\Models\OrderRecord;
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

        if ($this->response->typeIs('json')) {
            $data = $this->repository
                ->where(['status' => $status])
                ->setPresenter(\App\Repositories\Presenter\OrderPresenter::class)
                ->orderBy('id','desc')
                ->getDataTable($limit);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        $providers = Provider::where('payment_company_id',Auth::user()->payment_company_id)->orderBy('id','desc')->get();
        return $this->response->title(trans('app.admin.panel'))
            ->view('order.'.$status)
            ->data(compact('providers'))
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

        return $this->response->title(trans('app.view') . ' ' . trans('order.name'))
            ->data(compact('order'))
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
}
