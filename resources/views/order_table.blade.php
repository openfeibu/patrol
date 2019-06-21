<style>
    .ex-table{
        width:1000px;
        background:#fff
    }
    .content{
        text-align: center;
        font-family: 仿宋;
        font-size: 12px;
        height:30px;
        line-height: 30px;
    }
    .content_area{
        text-align: left;
        font-family: 仿宋;
        font-size: 14px;
    }

    .k-s-content{
        border:1px solid #333;
        text-align: left;
    }
    .k-w-table {
        border-style:solid;
        border-width:1px;
        border-collapse:collapse;
        font-size: 14px;
    }
    .line-table-height{
        position:relative;
        height:30px;
        line-height:30px;

    }
    .line-table-height td{
        height:100%;
        vertical-align:middle;
        /*display:table;*/
    }
    .line-table-height td span{
        vertical-align:middle;
        display:table-cell;
    }
    .line-table-c{
        text-align:center;


    }
    .line-table-t{
        text-indent:1em;
        border:1px;
    }
    .line-table-con{
        line-height:25px;
        min-height:50px;
    }
    .line-table-con td{min-height:50px;}

    .ex-table .layui-col-md1{
        width:10% !important;
    }

    .ex-table .layui-col-md5{
        width:40% !important;
    }
    .range90{
        transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        -webkit-transform: rotate(-90deg);
    }
    .td-img{
        border-top:none;
    }
    .td-img img{
        /*margin:5px;*/
    }
    .ex-table-p{
        font-size:30px;
        text-align:center;
        padding:20px;
    }
    .no_bottom_border{
        border-bottom: none;
    }
    .no_bottom_border td{
        border-bottom: none;
    }
    p{
        margin: 0px;
        height: 15px;
        line-height: 15px;
    }
</style>
<div class="ex-table">
    {{--<p class="ex-table-p">信息采集反馈表</p>--}}

    <table width="1000" class="k-w-table line_table member_table">
        <tbody>

        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md6" colspan="4">巡检单ID：{{ $order_record['order_id'] }}</td>
        </tr>

        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md6" >{{ trans('merchant.label.merchant_sn') }}：{{ $merchant->merchant_sn }}</td>
            <td class="k-s-content layui-col-md6">{{ trans('merchant.name') }}：{{ $merchant->name }}</td>
        </tr>
        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md6" >{{ trans('order_record.label.terminal_identification') }}：{{ $order_record['terminal_identification'] }}</td>
            <td class="k-s-content layui-col-md6">{{ trans('order_record.label.patrol_company') }}：{{ $order_record['patrol_company'] }}</td>
        </tr>
        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md6" >{{ trans('order_record.label.model') }}： {{ $order_record['model'] }}</td>
            <td class="k-s-content layui-col-md6">{{ trans('order_record.label.address') }}：{{ $order_record['address'] }}</td>
        </tr>
        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md6" >{{ trans('order_record.label.patrol_man') }}：{{ $order_record['patrol_man'] }}</td>
            <td class="k-s-content layui-col-md6">{{ trans('order_record.label.template') }}：{{ $order_record['template'] }}</td>
        </tr>
        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md6" >{{ trans('order_record.label.leader_phone') }}：{{ $order_record['leader_phone'] }}</td>
            <td class="k-s-content layui-col-md6">{{ trans('order_record.label.patrol_mode') }}：{{ $order_record['patrol_mode'] }}</td>
        </tr>
        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md6" >{{ trans('order_record.label.sn') }}：{{ $order_record['sn'] }}</td>
            <td class="k-s-content layui-col-md6">{{ trans('order_record.label.pn') }}：{{ $order_record['pn'] }}</td>
        </tr>
        <tr class="line-table-height  ">
            <td class="k-s-content layui-col-md1 line-table-c" >序号</td>
            <td class="k-s-content layui-col-md5 line-table-c">检查内容</td>
            <td class="k-s-content layui-col-md1 line-table-c" >结果</td>
            <td class="k-s-content layui-col-md5 line-table-c">描述</td>
        </tr>
        <tr class="line-table-height line-table-con" >
            <td class="k-s-content layui-col-md1 line-table-c" ><span>1</span></td>
            <td class="k-s-content layui-col-md5 "><span>POS机具是否有被移至他处使用或被改造或加装了其他设备（如移机需要新拍摄4张照片，填写变更单并盖章）？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['pos_is_transformational']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['pos_is_transformational_content']) ? $order_record['pos_is_transformational_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>2</span></td>
            <td class="k-s-content layui-col-md5"><span>POS机具是否处于正常工作状态？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['pos_is_normal']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['pos_is_transformational_content']) ? $order_record['pos_is_transformational_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>3</span></td>
            <td class="k-s-content layui-col-md5"><span>POS是否被粘贴其他标志？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['pos_is_signed']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['pos_is_signed_contet']) ? $order_record['pos_is_signed_contet'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>4</span></td>
            <td class="k-s-content layui-col-md5"><span>商户实际经营业务内容是否与原登记的内容一致？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['business_is_true']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['business_is_true_content']) ? $order_record['business_is_true_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>5</span></td>
            <td class="k-s-content layui-col-md5"><span>商户交易单据凭证的保管是否符合规定？（签购单签字后保留24个月）</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['trade_notes_is_storage_correctly']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['trade_notes_is_storage_correctly_content']) ? $order_record['trade_notes_is_storage_correctly_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>6</span></td>
            <td class="k-s-content layui-col-md5"><span>商户经营状况是否正常？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['manage_is_normal']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['manage_is_normal_content']) ? $order_record['manage_is_normal_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>7</span></td>
            <td class="k-s-content layui-col-md5"><span>商户收银员的流动情况？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['cashier_mobility']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['cashier_mobility_content']) ? $order_record['cashier_mobility_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>8</span></td>
            <td class="k-s-content layui-col-md5"><span>商户收银员是否经过培训后上岗？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['cashier_is_disciplinary']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['cashier_is_disciplinary_content']) ? $order_record['cashier_is_disciplinary_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>9</span></td>
            <td class="k-s-content layui-col-md5"><span>收银员银行卡受理业务的操作技能情况？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['cashier_band_card_operation_skills']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['cashier_band_card_operation_skills_content']) ? $order_record['cashier_band_card_operation_skills_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>10</span></td>
            <td class="k-s-content layui-col-md5"><span>机器保管是否完整？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['machine_is_storage_perfectly']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['machine_is_storage_perfectly_content']) ? $order_record['machine_is_storage_perfectly_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>11</span></td>
            <td class="k-s-content layui-col-md5"><span>是否拍摄照片？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['is_take_photos']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['is_take_photos_content']) ? $order_record['is_take_photos_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>12</span></td>
            <td class="k-s-content layui-col-md5"><span>是否按天结算？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['is_settlement_of_the_day']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['is_settlement_of_the_day_content']) ? $order_record['is_settlement_of_the_day_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>13</span></td>
            <td class="k-s-content layui-col-md5"><span>是否收取押金：</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['is_charge_deposit_amount']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>收取押金金额：{!!  !empty($order_record['charge_deposit_amount']) ? $order_record['charge_deposit_amount'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>14</span></td>
            <td class="k-s-content layui-col-md5"><span>是否出备机？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['is_standby_machine']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['is_standby_machine_content']) ? $order_record['is_standby_machine_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>15</span></td>
            <td class="k-s-content layui-col-md5"><span>是否遗失？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['is_lost']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['is_lost_content']) ? $order_record['is_lost_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-con">
            <td class="k-s-content layui-col-md1 line-table-c" ><span>16</span></td>
            <td class="k-s-content layui-col-md5"><span>是否损坏？</span></td>
            <td class="k-s-content layui-col-md1 line-table-c" ><span>{{ is_status_desc($order_record['is_damaged']) }}</span></td>
            <td class="k-s-content layui-col-md5 line-table-c"> <span>{!!  !empty($order_record['is_damaged_content']) ? $order_record['is_damaged_content'] : '/'  !!} </span></td>
        </tr>
        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md12 " colspan="4">结果：{{ $order_record['merchant_result_desc'] }} </td>
        </tr>
        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md12 " colspan="4">结果说明：{{ $order_record['merchant_result_content'] }} </td>
        </tr>
        <tr class="line-table-height line-table-t no_bottom_border">
            <td class="k-s-content layui-col-md12"  colspan="4">
                <span>{{ trans('order_record.label.door_images') }}: </span>

            </td>
        </tr>
        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md12 td-img"  colspan="4">
                @foreach($order_record['door_images'] as $image)
                    <img style="width:300px" src="{{ $image }}">
                @endforeach
            </td>
        </tr>
        <tr class="line-table-height line-table-t no_bottom_border">
            <td class="k-s-content layui-col-md12"  colspan="4">
                <span>{{ trans('order_record.label.address_images') }}: </span>

            </td>
        </tr>
        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md12 td-img"  colspan="4">
                @foreach($order_record['address_images'] as $image)
                    <img style="width:300px" src="{{ $image }}">
                @endforeach
            </td>
        </tr>
        <tr class="line-table-height line-table-t no_bottom_border">
            <td class="k-s-content layui-col-md12"  colspan="4">
                <span>{{ trans('order_record.label.inside_images') }}: </span>

            </td>
        </tr>
        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md12 td-img"  colspan="4">
                @foreach($order_record['inside_images'] as $image)
                    <img style="width:300px" src="{{ $image }}">
                @endforeach
            </td>
        </tr>
        <tr class="line-table-height line-table-t no_bottom_border">
            <td class="k-s-content layui-col-md12"  colspan="4">
                <span>{{ trans('order_record.label.pos_images') }}: </span>

            </td>
        </tr>
        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md12 td-img"  colspan="4">
                @foreach($order_record['pos_images'] as $image)
                    <img style="width:300px" src="{{ $image }}">
                @endforeach
            </td>
        </tr>
        <tr class="line-table-height line-table-t no_bottom_border">
            <td class="k-s-content layui-col-md12"  colspan="4">
                <span>{{ trans('order_record.label.checkstand_images') }}: </span>

            </td>
        </tr>
        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md12 td-img"  colspan="4">
                @foreach($order_record['checkstand_images'] as $image)
                    <img style="width:300px" src="{{ $image }}">
                @endforeach
            </td>
        </tr>
        <tr class="line-table-height line-table-t no_bottom_border">
            <td class="k-s-content layui-col-md12"  colspan="4">
                <span>{{ trans('order_record.label.test_images') }}: </span>

            </td>
        </tr>
        <tr class="line-table-height line-table-t ">
            <td class="k-s-content layui-col-md12 td-img"  colspan="4">
                @foreach($order_record['test_images'] as $image)
                    <img style="width:300px" src="{{ $image }}">
                @endforeach
            </td>
        </tr>
        <tr class="line-table-height line-table-t no_bottom_border">
            <td class="k-s-content layui-col-md12"  colspan="4">
                <span>{{ trans('order_record.label.pos_is_transformational_images') }}: </span>
            </td>
        </tr>
        <tr class="line-table-height line-table-t">
            @for($i=0;$i<4;$i++)
            <td class="k-s-content layui-col-md12 td-img" width="25%">
                @if(isset($order_record['pos_is_transformational_images'][$i]))
                    <img style="width:240px;" src="{{ $order_record['pos_is_transformational_images'][$i] }}">
                @endif
            </td>
            @endfor
        </tr>

        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md12 " colspan="4">
                <p>{{ trans('order_record.label.signature_image') }}： </p>
                @foreach($order_record['signature_image'] as $image)
                    <img style="width:300px" src="{{ $image }}">
                @endforeach
            </td>
        </tr>

        <tr class="line-table-height line-table-t">
            <td class="k-s-content layui-col-md12 td-img" colspan="4">
                <p>管理员备注: </p>
                @foreach($order_logs as $key => $order_log)<span>{{ $order_log->name }}（{{ trans('order_log.admin_type.'.$order_log->admin_type) }}）:{{ $order_log->content }}({{ $order_log->created_at }})</span><br/>@endforeach
            </td>
        </tr>
        </tbody>
    </table>
</div>