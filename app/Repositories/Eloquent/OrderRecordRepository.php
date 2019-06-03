<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\OrderRecordRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class OrderRecordRepository extends BaseRepository implements OrderRecordRepositoryInterface
{
    public function model()
    {
        return config('model.order.order_record.model');
    }
    public function getOrderRecordByOrderId($order_id)
    {
        $order_record_fields = config('model.order.order_record.fillable');

        $order_record = $this->model->select("*",'id as order_record_id')->where('order_id',$order_id)->orderBy('id','desc')->first();
        $order_record = $order_record ? $order_record->toArray() : [];
        if($order_record)
        {
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
        return $order_record;
    }
}