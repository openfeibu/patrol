<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderRecord;
use App\Repositories\Eloquent\PageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Banner;
use App\Models\User;
use App\Models\Order;
use Tymon\JWTAuth\JWTAuth;
use Log,Input;

class OrderController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.api');
        $this->user = User::getUser();
    }
    public function getOrders(Request $request)
    {
        $user = User::getUser();

        $status = $request->input('status','');
        $orders = Order::select("merchants.*","merchants.id as merchant_id","orders.*")
            ->join('merchants','merchants.id','orders.merchant_id');

        if($status)
        {
            $orders = $orders->where('orders.status',$status);
        }

        $orders = $orders->where('orders.user_id',$user->id)
            ->orderBy('orders.id','desc')
            ->paginate(20);

        $orders_data = $orders->toArray()['data'];

        return response()->json([
            'code' => '200',
            'total' => $orders->total(),
            'data' => $orders_data,
        ]);

    }
    public function getOrder(Request $request,$id)
    {
        $order = Order::select("merchants.*","merchants.id as merchant_id","orders.*","payment_companies.auth_file")
            ->join('merchants','merchants.id','=','orders.merchant_id')
            ->join("payment_companies",'payment_companies.id','=',"orders.payment_company_id")
            ->where('orders.id',$id)
            ->first();

        $order_record = OrderRecord::select("*",'id as order_record_id')->where('order_id',$order->id)->orderBy('id','desc')->first();

        $order_record_fields = config('model.order.order_record.fillable');

        $data = array();
        if(!$order_record)
        {
            $data['order_record_id'] = null;
            foreach ($order_record_fields as $field)
            {
                $data[$field] = null;
            }
        }else{
            $data = $order_record->toArray();
        }
        foreach ($order_record_fields as $key => $field)
        {
            if(strpos($field,'image'))
            {
                $data[$field.'_thumb'] = handle_images_thumb('order',explode(',',$data[$field]));
                $data[$field] = handle_images(explode(',',$data[$field]));
            }
        }
        $data = array_merge($order->toArray(),$data);

        return response()->json([
            'code' => '200',
            'data' => $data,
        ]);

    }

    public function saveOrder(Request $request)
    {
        $order_record_id = $request->input('order_record_id','');
        $order_id = $request->order_id;

        $request_data = $request->all();
        $order_record_data = [];
        $order_record_fields = config('model.order.order_record.fillable');
        foreach ($order_record_fields as $field)
        {
            if(isset($request_data[$field]))
            {
                $order_record_data[$field] = $request_data[$field];
            }
        }
        unset($order_record_data['status'],$order_record_data['user_id']);

        //存在工单巡检记录且非退回状态
        $is_update = 0;

        $order_record = OrderRecord::where('order_id',$order_id)->first();
        if($order_record && ($order_record['status'] == 'finish' || $order_record['status'] == 'pass'))
        {
            return response()->json([
                'code' => '400',
                'message' => '该巡检任务已完成，请勿重复提交',
            ],400);
        }

        if($order_record_data)
        {
            if($order_record && $order_record['status'] == 'working')
            {
                if(isset($order_record_data['signature_image']))
                {
                    $order_record_data['status'] = 'finish';
                    Order::where('id',$order_record['order_id'])->update(['status' => 'finish']);
                }
                OrderRecord::where('id',$order_record['id'])->update($order_record_data);
            }
            else{
                $order_record_data['user_id'] = $this->user->id;
                $order_record_data['status'] = 'working';
                $order_record = OrderRecord::create($order_record_data);
            }

            $order_record = OrderRecord::where('id',$order_record['id'])->first();

            return response()->json([
                'code' => '200',
                'message' => '提交成功',
                'data' => $order_record
            ],200);
        }

        return response()->json([
            'code' => '400',
            'message' => '未提交数据',
        ],400);
    }
    public function uploadImage(Request $request)
    {
        $images_url = app('image_service')->uploadImages(Input::all(), 'order',1);

        return response()->json([
            'code' => '200',
            'data' => $images_url
        ],200);
    }
}
