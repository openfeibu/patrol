<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('order.name') }}详情</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <fieldset class="fb-main-table">
                <form class="layui-form" action="{{guard_url('order/'.$order->id)}}" method="post" method="post" lay-filter="fb-form">
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
 })
</script>
{!! Theme::asset()->container('ueditor')->scripts() !!}