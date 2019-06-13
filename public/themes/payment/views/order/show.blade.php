<style>
.ex-table{
	width:1000px;
	background:#fff
}
 .line_table  tr{bordr:1px solid #333;}
 .line_table  tr td { bordr:1px solid #333;border-bottom:0; }
 .line_table { line-height: 25px; text-align: center; border-collapse:collapse;border:1px solid #333}
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
	display:table;
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
	margin:5px;
}
.ex-table-p{
	font-size:30px;
	text-align:center;
	padding:20px;
}
</style>
<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('order.name') }}详情</cite></a>
        </div>
    </div>
    <div class="main_full">
	<!-- 表格 -->
	<div class="ex-table">
    <p class="ex-table-p">信息采集反馈表</p>

<table width="1000" class="k-w-table line_table member_table">
    <tbody>


    <tr class="line-table-height line-table-t">
        <td class="k-s-content layui-col-md6" >商户编号：依据商户明细如实填写</td>
        <td class="k-s-content layui-col-md6">商户名称：依据商户明细如实填写</td>
		<td class="k-s-content layui-col-md6" >终端标识：开店宝</td>
        <td class="k-s-content layui-col-md6">巡检方：海带互联网金融信息服务（上海）有限公司</td>
		<td class="k-s-content layui-col-md6" >终端种类： W6900</td>
        <td class="k-s-content layui-col-md6">终端地址：依据商户明细如实填写，不正确请更正</td>
		<td class="k-s-content layui-col-md6" >巡检人员：巡检人员签名</td>
        <td class="k-s-content layui-col-md6">模板类型：开店宝模板</td>
		<td class="k-s-content layui-col-md6" >绑定电话：向店员询问负责人电话</td>
        <td class="k-s-content layui-col-md6">巡检方式：实地巡检</td>
		<td class="k-s-content layui-col-md6" >机具/SN号： 121312321</td>
        <td class="k-s-content layui-col-md6">机具/PN号： :12312321</td>
    </tr>
	<tr class="line-table-height  ">
        <td class="k-s-content layui-col-md1 line-table-c" >序号</td>
        <td class="k-s-content layui-col-md5 line-table-c">检查内容</td>
		<td class="k-s-content layui-col-md1 line-table-c" >结果</td>
        <td class="k-s-content layui-col-md5 line-table-c">描述</td>
    </tr>
	<tr class="line-table-height line-table-con" >
        <td class="k-s-content layui-col-md1 line-table-c" ><span>1</span></td>
        <td class="k-s-content layui-col-md5 ">
		<span>POS机具是否有被移至他处使用或被改造或加装了其他设备（如移机需要新拍摄4张照片，填写变更单并盖章）？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
        <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
   <tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>2</span></td>
        <td class="k-s-content layui-col-md5"><span>POS机具是否处于正常工作状态？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>3</span></td>
        <td class="k-s-content layui-col-md5"><span>XX标识是否被覆盖？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>4</span></td>
        <td class="k-s-content layui-col-md5"><span>商户实际经营业务内容是否与原登记的内容一致？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>5</span></td>
        <td class="k-s-content layui-col-md5"><span>商户交易单据凭证的保管是否符合规定？（签购单签字后保留24个月）</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>6</span></td>
        <td class="k-s-content layui-col-md5"><span>商户经营状况是否正常？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>7</span></td>
        <td class="k-s-content layui-col-md5"><span>商户收银员的流动情况？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>8</span></td>
        <td class="k-s-content layui-col-md5"><span>商户收银员是否经过培训后上岗？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>9</span></td>
        <td class="k-s-content layui-col-md5"><span>收银员银行卡受理业务的操作技能情况？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>10</span></td>
        <td class="k-s-content layui-col-md5"><span>机器保管是否完整？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>11</span></td>
        <td class="k-s-content layui-col-md5"><span>是否拍摄照片？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>12</span></td>
        <td class="k-s-content layui-col-md5"><span>是否按天结算？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>13</span></td>
        <td class="k-s-content layui-col-md5"><span>是否收取押金：</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>14</span></td>
        <td class="k-s-content layui-col-md5"><span>是否出备机？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>15</span></td>
        <td class="k-s-content layui-col-md5"><span>是否遗失？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-con">
        <td class="k-s-content layui-col-md1 line-table-c" ><span>16</span></td>
        <td class="k-s-content layui-col-md5"><span>是否损坏？</span></td>
		<td class="k-s-content layui-col-md1 line-table-c" ><span>是</span></td>
       <td class="k-s-content layui-col-md5 line-table-c"> <span>/</span></td>
    </tr>
	<tr class="line-table-height line-table-t">
        <td class="k-s-content layui-col-md12 " >结果：正常商户 </td>
    </tr>
	<tr class="line-table-height line-table-t">
        <td class="k-s-content layui-col-md12 " >结果说明： </td>
    </tr>

	<tr class="line-table-height line-table-t">
        <td class="k-s-content layui-col-md12" >
			<span>POS机具被移至他处使用或被改造或加装了其他设备： </span>

		</td>
		<td class="k-s-content layui-col-md12 td-img" >
		<img style="width:150px" src="http://patrolapi.feibu.info/image/original/merchant/watermark/%E6%98%86%E6%98%8E%E5%B8%82%E7%9B%98%E9%BE%99%E5%8C%BA%E5%90%9B%E4%B8%BD%E5%89%AF%E9%A3%9F%E5%BA%97-20190611141239356271.jpg">
		<img style="width:150px" src="http://patrolapi.feibu.info/image/original/merchant/watermark/%E6%98%86%E6%98%8E%E5%B8%82%E7%9B%98%E9%BE%99%E5%8C%BA%E5%90%9B%E4%B8%BD%E5%89%AF%E9%A3%9F%E5%BA%97-20190611141239356271.jpg">
		<img style="width:150px" src="http://patrolapi.feibu.info/image/original/merchant/watermark/%E6%98%86%E6%98%8E%E5%B8%82%E7%9B%98%E9%BE%99%E5%8C%BA%E5%90%9B%E4%B8%BD%E5%89%AF%E9%A3%9F%E5%BA%97-20190611141239356271.jpg">
		<img style="width:150px" src="http://patrolapi.feibu.info/image/original/merchant/watermark/%E6%98%86%E6%98%8E%E5%B8%82%E7%9B%98%E9%BE%99%E5%8C%BA%E5%90%9B%E4%B8%BD%E5%89%AF%E9%A3%9F%E5%BA%97-20190611141239356271.jpg">
		</td>
    </tr>
	<tr class="line-table-height line-table-t">
        <td class="k-s-content layui-col-md12" >
			<span>商户门头照: </span>

		</td>
		<td class="k-s-content layui-col-md12 td-img" >
		<img style="width:150px" src="http://patrolapi.feibu.info/image/original/merchant/watermark/%E6%98%86%E6%98%8E%E5%B8%82%E7%9B%98%E9%BE%99%E5%8C%BA%E5%90%9B%E4%B8%BD%E5%89%AF%E9%A3%9F%E5%BA%97-20190611141239356271.jpg">

		</td>
    </tr>
	<tr class="line-table-height line-table-t">
        <td class="k-s-content layui-col-md12" >
			<span>地址门牌照: </span>

		</td>
		<td class="k-s-content layui-col-md12 td-img" >
		<img style="width:150px" src="http://patrolapi.feibu.info/image/original/merchant/watermark/%E6%98%86%E6%98%8E%E5%B8%82%E7%9B%98%E9%BE%99%E5%8C%BA%E5%90%9B%E4%B8%BD%E5%89%AF%E9%A3%9F%E5%BA%97-20190611141239356271.jpg">

		</td>
    </tr>
	<tr class="line-table-height line-table-t">
        <td class="k-s-content layui-col-md12"  >
			<span>内部经营场所照: </span>

		</td>
		<td class="k-s-content layui-col-md12 td-img" >
		<img style="width:150px" src="http://patrolapi.feibu.info/image/original/merchant/watermark/%E6%98%86%E6%98%8E%E5%B8%82%E7%9B%98%E9%BE%99%E5%8C%BA%E5%90%9B%E4%B8%BD%E5%89%AF%E9%A3%9F%E5%BA%97-20190611141239356271.jpg">

		</td>
    </tr>
	<tr class="line-table-height line-table-t">
        <td class="k-s-content layui-col-md12" >
			<span>POS机背面SN/PN号照片: </span>

		</td>
		<td class="k-s-content layui-col-md12 td-img" >
		<img style="width:150px" src="http://patrolapi.feibu.info/image/original/merchant/watermark/%E6%98%86%E6%98%8E%E5%B8%82%E7%9B%98%E9%BE%99%E5%8C%BA%E5%90%9B%E4%B8%BD%E5%89%AF%E9%A3%9F%E5%BA%97-20190611141239356271.jpg">

		</td>
    </tr>
	<tr class="line-table-height line-table-t">
        <td class="k-s-content layui-col-md12" >
			<span>收银台照片: </span>

		</td>
		<td class="k-s-content layui-col-md12 td-img" >
		<img style="width:150px" src="http://patrolapi.feibu.info/image/original/merchant/watermark/%E6%98%86%E6%98%8E%E5%B8%82%E7%9B%98%E9%BE%99%E5%8C%BA%E5%90%9B%E4%B8%BD%E5%89%AF%E9%A3%9F%E5%BA%97-20190611141239356271.jpg">

		</td>
    </tr>
	<tr class="line-table-height line-table-t">
        <td class="k-s-content layui-col-md12" >
			<span>测试单: </span>

		</td>
		<td class="k-s-content layui-col-md12 td-img" >
		<img style="width:150px" src="http://patrolapi.feibu.info/image/original/merchant/watermark/%E6%98%86%E6%98%8E%E5%B8%82%E7%9B%98%E9%BE%99%E5%8C%BA%E5%90%9B%E4%B8%BD%E5%89%AF%E9%A3%9F%E5%BA%97-20190611141239356271.jpg">

		</td>
    </tr>
	<tr class="line-table-height line-table-t">
        <td class="k-s-content layui-col-md12 " >
		<span>商户签名： </span>
		<img class="range90" style="width:100px;float:right;margin:-50px 150px -50px 0" src="http://patrolapi.feibu.info/image/original/merchant/watermark/昆明市盘龙区君丽副食店-20190611141503375670.jpg">
		</td>
    </tr>
    <tr class="line-table-height line-table-t">
        <td class="k-s-content layui-col-md12" >
            <span>备注: </span>

        </td>
        <td class="k-s-content layui-col-md12 td-img" >
            @foreach($order_logs as $key => $order_log)
            <p class="input-p">{{ $order_log->name }}（{{ trans('order_log.admin_type.'.$order_log->admin_type) }}）:{{ $order_log->content }}({{ $order_log->created_at }})</p>
            @endforeach
        </td>
    </tr>
    </tbody>
</table>
	</div>
		<!-- 详情 -->
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <fieldset class="fb-main-table">
                <form class="layui-form" action="{{guard_url('order/'.$order->id)}}" method="post" method="post" lay-filter="fb-form">
                    @if($order_logs->count())
                        <fieldset class="layui-elem-field order-des" >
                            <legend>管理员备注</legend>
                            @foreach($order_logs as $key => $order_log)
                                <div class="layui-form-item">
                                    <label class="layui-form-label">{{ $order_log->name }}（{{ trans('order_log.admin_type.'.$order_log->admin_type) }}）:</label>
                                    <div class="layui-input-inline">
                                        <p class="input-p">{{ $order_log->content }}</p>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">{{ $order_log->created_at }}</div>
                                </div>
                            @endforeach
                        </fieldset>
                    @endif
                    <fieldset class="layui-elem-field order-des" >
                        <legend>商户详情</legend>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ trans('merchant.name') }}</label>
                            <div class="layui-input-inline">
                                <p class="input-p">{{ $merchant->name }}</p>
                            </div>

                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ trans('merchant.label.linkman') }}</label>
                            <div class="layui-input-inline">
                               <p class="input-p">{{ $merchant->linkman }}</p>
                            </div>

                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ trans('merchant.label.phone') }}</label>
                            <div class="layui-input-inline">
                                <p class="input-p">{{ $merchant->phone }}</p>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ trans('merchant.label.merchant_sn') }}</label>
                            <div class="layui-input-inline">
                                <p class="input-p">{{ $merchant->merchant_sn }}</p>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ trans('merchant.label.model') }}</label>
                            <div class="layui-input-inline">
                                <p class="input-p">{{ $merchant->model }}</p>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ trans('merchant.label.pn') }}</label>
                            <div class="layui-input-inline">
                                <p class="input-p">{{ $merchant->pn }}</p>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ trans('merchant.label.sn') }}</label>
                            <div class="layui-input-inline">
                                <p class="input-p">{{ $merchant->sn }}</p>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ trans('merchant.label.address') }}</label>
                            <div class="layui-input-inline">
                                <p class="input-p">{{ $merchant->address }}</p>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ trans('merchant.label.province') }}</label>
                            <div class="layui-input-inline">
                                <p class="input-p">{{ $merchant->province }}</p>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ trans('merchant.label.city') }}</label>
                            <div class="layui-input-inline">
                                <p class="input-p">{{ $merchant->city }}</p>
                            </div>
                        </div>
                    </fieldset>
                    @if($order_record)
                        <fieldset class="layui-elem-field  order-des" >
                            <legend>巡检详情</legend>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order.label.status') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['status_desc'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.patrol_company') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['patrol_company'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.terminal_identification') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['terminal_identification'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.model') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['model'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.address') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['address'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.linkman') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['linkman'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.phone') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['phone'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.date') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['date'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.patrol_man') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['patrol_man'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.template') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['template'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.leader_phone') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['leader_phone'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.patrol_mode') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['patrol_mode'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.sn') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['sn'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.pn') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['pn'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.door_images') }}</label>
                                <div class="layui-input-block">
                                    @foreach($order_record['door_images'] as $image)
                                        <ul >
                                            <li>
                                                <img src="{{ $image }}">
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.address_images') }}</label>
                                <div class="layui-input-block">
                                    @foreach($order_record['address_images'] as $image)
                                        <ul>
                                            <li>
                                                <img src="{{ $image }}">
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.inside_images') }}</label>
                                <div class="layui-input-block">
                                    @foreach($order_record['inside_images'] as $image)
                                        <ul>
                                            <li>
                                                <img src="{{ $image }}">
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.pos_images') }}</label>
                                <div class="layui-input-block">
                                    @foreach($order_record['pos_images'] as $image)
                                        <ul>
                                            <li>
                                                <img src="{{ $image }}">
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.checkstand_images') }}</label>
                                <div class="layui-input-block">
                                    @foreach($order_record['checkstand_images'] as $image)
                                        <ul>
                                            <li>
                                                <img src="{{ $image }}">
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.test_images') }}</label>
                                <div class="layui-input-block">
                                    @foreach($order_record['test_images'] as $image)
                                        <ul>
                                            <li>
                                                <img src="{{ $image }}">
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.pos_is_transformational') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['pos_is_transformational']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['pos_is_transformational_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.pos_is_transformational_images') }}</label>
                                <div class="layui-input-block">
                                    @foreach($order_record['pos_is_transformational_images'] as $image)
                                        <ul>
                                            <li>
                                                <img src="{{ $image }}">
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.pos_is_normal') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['pos_is_normal']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['pos_is_normal_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.pos_is_signed') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['pos_is_signed']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['pos_is_signed_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.business_is_true') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['business_is_true']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['business_is_true_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.trade_notes_is_storage_correctly') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['trade_notes_is_storage_correctly']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['trade_notes_is_storage_correctly_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.manage_is_normal') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['manage_is_normal']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['manage_is_normal_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.cashier_mobility') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['cashier_mobility']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['cashier_mobility_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.cashier_is_disciplinary') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['cashier_is_disciplinary']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['cashier_is_disciplinary_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.cashier_band_card_operation_skills') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['cashier_band_card_operation_skills']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['cashier_band_card_operation_skills_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.machine_is_storage_perfectly') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['machine_is_storage_perfectly']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['machine_is_storage_perfectly_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.is_take_photos') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['is_take_photos']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['is_take_photos_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.is_settlement_of_the_day') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['is_settlement_of_the_day']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['is_settlement_of_the_day_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.is_charge_deposit_amount') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['is_charge_deposit_amount']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.charge_deposit_amount') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['charge_deposit_amount'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.is_standby_machine') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['is_standby_machine']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['is_standby_machine_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.is_lost') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['is_lost']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['is_lost_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.is_damaged') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ is_status_desc($order_record['is_damaged']) }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['is_damaged_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.merchant_result') }}</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['merchant_result_desc'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['merchant_result_content'] }}</p>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ trans('order_record.label.signature_image') }}</label>
                                <div class="layui-input-block">
                                    @foreach($order_record['signature_image'] as $image)
                                        <ul>
                                            <li>
                                                <img class="range90" src="{{ $image }}">
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            @if($order_record['status'] == 'return')
                            <div class="layui-form-item">
                                <label class="layui-form-label">退单理由</label>
                                <div class="layui-input-inline">
                                    <p class="input-p">{{ $order_record['return_content'] }}</p>
                                </div>
                            </div>
                            @endif
                        </fieldset>
                        @if($order_record['status'] == 'finish')
						<div class="layui-btn-box"> 
						    <a class="layui-btn layui-btn-lg layui-btn-normal " tag="pass">通过</a>
						    <a class="layui-btn layui-btn-lg layui-btn-danger " tag="return">退回</a>
						</div>
                        @endif
                    @endif
                    {!!Form::token()!!}
                    <input type="hidden" name="_method" value="PUT">
                </form>
        </div>

    </div>
</div>
</div>
<script>
 layui.use(['jquery','element','table'], function(){
        var table = layui.table;
        var form = layui.form;
        var $ = layui.$;
		
		$(".layui-form-item img").on("click",function(){
			var that = $(this);
			if(that.hasClass("range90")){
				return false;
			}
			var json = {};
			json.title="";
			json.id="";
			json.start=0;
			json.data=[
				{
					"alt":"",
					"pid":"",
					"src":that.attr("src"),
					"thumb":"",
				}
			];

			 
			layer.photos({
				photos: json
				,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
			  });
		})
		
	   $(".layui-btn-box .layui-btn").on('click', function(){
            var data = {};
            data['_token'] = "{!! csrf_token() !!}";
			data.id="{{$order->id}}";
			var tag = $(this).attr("tag");
            if(tag === 'detail'){
                layer.msg('ID：'+ data.id + ' 的查看操作');
            } else if(tag === 'del'){
                layer.confirm('真的删除行么', function(index){
                    layer.close(index);
                    var load = layer.load();
                    $.ajax({
                        url : main_url+'/'+data.id,
                        data : data,
                        type : 'delete',
                        success : function (data) {
                            obj.del();
                            layer.close(load);
                        },
                        error : function (jqXHR, textStatus, errorThrown) {
                            layer.close(load);
                            layer.msg('服务器出错');
                        }
                    });
                });
            }else if(tag === 'return'){
                layer.prompt({
                    formType: 2,
                    value: '',
                    title: '请填写退单理由',
                    area: ['400px', '200px'] //自定义文本域宽高
                }, function(value, index, elem){
                    var load = layer.load();
                    $.ajax({
                        url : "{{ guard_url('return_order') }}",
                        data : {'id':data.id,'return_content':value,'_token':"{!! csrf_token() !!}"},
                        type : 'post',
                        success : function (data) {
                            
                            layer.msg(data.msg);
                            layer.close(load);
                            layer.close(index);
							window.location.reload();
                        },
                        error : function (jqXHR, textStatus, errorThrown) {
                            layer.close(load);
                            layer.msg('服务器出错');
                        }
                    });
                });
            }else if(tag === 'pass'){
                layer.confirm('确定通过审核么？', function(index){
                    layer.close(index);
                    var load = layer.load();
                    $.ajax({
                        url : "{{ guard_url('pass_order') }}",
                        data : {'id':data.id,'_token':"{!! csrf_token() !!}"},
                        type : 'post',
                        success : function (data) {
                            window.location.reload();
                            layer.close(load);
                        },
                        error : function (jqXHR, textStatus, errorThrown) {
                            layer.close(load);
                            layer.msg('服务器出错');
                        }
                    });
                });
            }
        });
		
 })
</script>

{!! Theme::asset()->container('ueditor')->scripts() !!}