<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderRecord;
use App\Repositories\Eloquent\PageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Banner;
use App\Models\User;
use App\Models\Order;
use App\Models\Merchant;
use Tymon\JWTAuth\JWTAuth;
use App\Services\AmapService;
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
        $search_key = $request->input('search_key','');

        $orders = Order::select("merchants.*","merchants.id as merchant_id","orders.*")
            ->join('merchants','merchants.id','orders.merchant_id')
            ->where('orders.user_id',$user->id)
            ->when($status, function ($query) use ($status) {
                return $query->where(function ($query) use ($status) {
                    $query->where('orders.status',$status);
                });
            })
            ->when($search_key, function ($query) use ($search_key) {
                return $query->where(function ($query) use ($search_key) {
                    $query->where('merchants.name','like','%'.$search_key.'%')
                    ->orWhere('merchants.merchant_sn','like','%'.$search_key.'%');
                });
            })
            ->orderBy('orders.id','desc')
            ->paginate(20);

        $orders_data = $orders->toArray()['data'];

        foreach ($orders_data as $key=> $order) {
            if($order['status'] == 'return')
            {
                $orders_data[$key]['return_content'] = OrderRecord::where('order_id',$order['id'])->where('status','return')->orderBy('id','desc')->value('return_content');
            }else{
                $orders_data[$key]['return_content'] = '';
            }
        }
        return response()->json([
            'code' => '200',
            'total' => $orders->total(),
            'data' => $orders_data,
        ]);

    }
    public function getOrder(Request $request,$id)
    {
        $order = Order::select("orders.*")
            ->where('orders.id',$id)
            ->first();

        $merchant = Merchant::select("merchants.*","payment_companies.auth_file")
            ->join("payment_companies",'payment_companies.id','=',"merchants.payment_company_id")
            ->where('merchants.id',$order->merchant_id)
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

        $data['status'] = $order->status;
        $data['status_desc'] = $order->status_desc;

        if($order['status'] == 'return')
        {
            $data['return_content'] = OrderRecord::where('order_id',$order['id'])->where('status','return')->orderBy('id','desc')->value('return_content');
        }else{
            $data['return_content'] = '';
        }


        foreach ($order_record_fields as $key => $field)
        {
            if(strpos($field,'image') !== false)
            {

                if($data[$field])
                {
                    $data[$field.'_path'] = explode(',',$data[$field]);
                    $data[$field.'_thumb'] = handle_images_thumb('order',explode(',',$data[$field]));
                    $data[$field] = handle_images(explode(',',$data[$field]));

                }else{
                    $data[$field.'_path'] = [];
                    $data[$field.'_thumb'] = [];
                    $data[$field] = [];
                }
            }
        }
        $data = array_merge($order->toArray(),$data);

        $merchant->auth_file = handle_image_url($merchant->auth_file ?? config('common.auth_file'));

        return response()->json([
            'code' => '200',
            'data' => [
                'merchant' => $merchant,
                'order' => $data
            ],
        ]);

    }

    public function saveOrder(Request $request)
    {
        $order_record_id = $request->input('order_record_id','');
        $order_id = $request->order_id;

        if(!$order_id)
        {
            return response()->json([
                'code' => '400',
                'message' => 'order_id 不能为空',
            ],400);
        }
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
        $is_finish = isset($order_record_data['status']) && $order_record_data['status'] == 'finish' ? true :false;
        unset($order_record_data['status'],$order_record_data['user_id']);

        //存在工单巡检记录且非退回状态
        $is_update = 0;

        $order_record = OrderRecord::where('order_id',$order_id)->orderBy('id','desc')->first();
        if($order_record && ($order_record['status'] == 'finish' || $order_record['status'] == 'pass'))
        {
            return response()->json([
                'code' => '400',
                'message' => '该巡检任务已完成，请勿重复提交',
            ],400);
        }

        if($order_record_data)
        {
            if($order_record)
            {
                if($order_record['status'] == 'working')
                {
//                    if(isset($order_record_data['signature_image']))
//                    {
//                        $order_record_data['status'] = 'finish';
//                        Order::where('id',$order_record['order_id'])->update(['status' => 'finish']);
//                    }
                    if($is_finish)
                    {
                        $order_record_data['status'] = 'finish';
                        Order::where('id',$order_record['order_id'])->update(['status' => 'finish']);
                    }
                    OrderRecord::where('id',$order_record['id'])->update($order_record_data);
                }
                if($order_record['status'] == 'return')
                {
                    $order_record_data['user_id'] = $this->user->id;
                    $order_record_data['status'] = 'working';

                    if($is_finish)
                    {
                        $order_record_data['status'] = 'finish';
                        Order::where('id',$order_record['order_id'])->update(['status' => 'finish']);
                    }

                    $order_record_data = array_merge($order_record->toArray(),$order_record_data);
                    unset($order_record_data['id'],$order_record_data['return_content'],$order_record_data['signature_image']);
                    $order_record = OrderRecord::create($order_record_data);
                }

            }
            else{
                $order_record_data['user_id'] = $this->user->id;
                $order_record_data['status'] = 'working';
                $order_record = OrderRecord::create($order_record_data);
                Order::where('id',$order_record['order_id'])->update(['status' => 'working']);
            }

            return response()->json([
                'code' => '200',
                'message' => '提交成功',
            ],200);
        }

        return response()->json([
            'code' => '400',
            'message' => '未提交数据',
        ],400);
    }
    public function uploadImage(Request $request)
    {
        $order = Order::where('orders.id',$request->order_id)->first();
        $merchant_name = $order->merchant->name;
        $longitude = $request->input('longitude','');
        $latitude =  $request->input('latitude','');
        $address = '无法获取地理位置';
        if($longitude)
        {
            $amap_service = new AmapService();
            $amap_data = $amap_service->geocode_regeo($longitude.','.$latitude);
            $address = $amap_data['status'] ? $amap_data['regeocode']['formatted_address'] : $address;
        }

        $images_url = app('image_service')->uploadOrderImages(Input::all(), $merchant_name,$address,1);

        return response()->json([
            'code' => '200',
            'data' => $images_url
        ],200);
    }
    public function getOrderCount(Request $request)
    {
        $status = $request->get('status','return');

        $count = Order::where('user_id',$this->user->id)
            ->where('status',$status)
            ->count();

        return response()->json([
            'code' => '200',
            'data' => $count
        ],200);
    }

}
