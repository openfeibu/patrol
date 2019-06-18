<?php
namespace App\Services;

use TCPDF;
use App\Models\Order;
use App\Models\Merchant;
use App\Models\OrderRecord;
use App\Models\OrderLog;
use App\Repositories\Eloquent\OrderRepository;
use Image;

class ExportPdfService
{
    public function __construct()
    {
        //$this->pdf = new TCPDF();
    }
    public function export_orders($orders)
    {
        set_time_limit(0);
        $pdf = new \TCPDF($orientation='P', $unit='px',array(900,3200));
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("Gouweiba");
        $pdf->SetTitle("巡检单");
        $pdf->SetSubject('巡检单');
        $pdf->SetKeywords('巡检单');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(9, 10,0);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(true);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('stsongstdlight');
        $order_record_fields = config('model.order.order_record.fillable');
        $i = 0;
        foreach ($orders as $key => $order)
        {
            $i++;
            $merchant = Merchant::where('id',$order['merchant_id'])->first();
            $order_record = OrderRecord::select("*",'id as order_record_id')->where('order_id',$order['id'])->orderBy('id','desc')->first();

            if($order_record)
            {
                $order_record = $order_record->toArray();
                foreach ($order_record_fields as $key => $field)
                {
                    if(strpos($field,'image') !== false)
                    {

                        if($order_record[$field])
                        {

                            if(strpos($field,'signature') !== false)
                            {
                                $image_url = $order_record[$field];
                                $image_arr = explode('/',$image_url);
                                $image_path = '';
                                foreach ($image_arr as $key => $val)
                                {
                                    if(strpos($val,'.') !== false)
                                    {
                                        $image_name_arr = explode('.',$val);
                                        $image_all_name = $val;
                                        $image_name = $image_name_arr[0];
                                        $extension = $image_name_arr[1];
                                    }else{
                                        $image_path .= '/'.$val;
                                    }
                                }
                                $directory = storage_path('uploads');
                                $image_directory = $directory.$image_url;
                                $new_image_path = $directory.$image_path.'/'.$image_name.'_rotate.'.$extension;
                                if(!file_exists($new_image_path))
                                {
                                    $img = Image::make($image_directory);
                                    $img->rotate(90);
                                    $img->save($new_image_path);
                                }
                                $order_record[$field] = $image_path.'/'.$image_name.'_rotate.'.$extension;
                            }
                            $order_record[$field] = handle_images(explode(',',$order_record[$field]));
                        }else{
                            $order_record[$field] = [];
                        }
                    }
                }
            }
            $order_logs = OrderLog::where('order_id',$order['id'])->where('type','note')->orderBy('id','desc')->get();
            $content = view('order_table',compact('order','order_record','order_logs','merchant'));
            $content = $content->render();
            $pdf->AddPage();
            $pdf->setPageMark();
            $pdf->writeHTML($content, true, false, false, false, '');


        }
        if($i == 0)
        {
            $pdf->AddPage();
        }
        $pdf->lastPage();
        $pdf->Output("巡检单".date('YmdHis') . '.pdf', 'D');
        exit;
    }

}