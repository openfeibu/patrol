<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('order.name') }}管理</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            <div class="tabel-message">
                <div class="layui-form-item order_search layui-form">
                    <div class="tabel-btn">
                        <button class="layui-btn layui-btn-warm push_provider" data-type="push_provider" data-events="push_provider">批量分发服务商</button>
                        <button class="layui-btn layui-btn-primary " data-type="del" data-events="del">删除</button>

                    </div>
					<div class="layui-inline mt10 ">
                        <label class="layui-form-label">{{ trans("payment_company.name") }}：</label>
                    </div>
                    <div class="layui-inline mt10 layui-input-search">
                       
						
                        <select name="payment_company_id" class="search_key layui-select" lay-verify="">
                            <option value="0">全部</option>
                            @foreach($payment_companies as $key => $payment_company)
                                <option value="{{ $payment_company->id }}" @if($payment_company->id == $payment_company_id) selected @endif>{{ $payment_company->name }}</option>
                            @endforeach
                        </select>
                    </div>
					<br>
                    <div class="layui-inline mt10">
                        <input class="layui-input layui-input-inline search_key" name="search_province" id="demoReload" placeholder="省份" autocomplete="off" value="{{ $search_province }}">
                    </div>
                    <div class="layui-inline mt10">
                        <input class="layui-input layui-input-inline search_key" name="search_city" id="demoReload" placeholder="城市" autocomplete="off" value="{{ $search_city }}">
                    </div>
                    <div class="layui-inline mt10">
                        <input class="layui-input layui-input-inline search_key" name="search_address" id="demoReload" placeholder="地址" autocomplete="off" value="{{ $search_address }}">
                    </div>
                    <div class="layui-inline mt10">
                        <input class="layui-input layui-input-inline search_key" name="search_merchant_name" id="demoReload" placeholder="商户名" autocomplete="off" value="{{ $search_merchant_name }}">
                    </div>
                    <button class="layui-btn mt10" data-type="reload">搜索</button>
                </div>
            </div>

            <table id="fb-table" class="layui-table"  lay-filter="fb-table">

            </table>
        </div>
    </div>
</div>

<div class="provider_content" style="display:none;">
    <form class="layui-form">
        <div class="layui-form-item">
            @foreach($providers as $key => $provider)
                <input type="radio" name="provider_id" value="{{ $provider->id }}" title="{{ $provider->name }}">
            @endforeach
        </div>
    </form>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-sm" lay-event="edit">详情</a>
    <a class="layui-btn layui-btn-normal layui-btn-sm" lay-event="remark">备注</a>
</script>
<script type="text/html" id="imageTEM">
    <img src="@{{d.image}}" alt="" height="28">
</script>

<script>
    var main_url = "{{guard_url('order')}}";
    var delete_all_url = "{{guard_url('order/destroyAll')}}";
    var index_url = "{{guard_url('order_pending_provider')}}";
    layui.use(['jquery','element','table','form'], function(){
        var table = layui.table;
        var form = layui.form;
        var $ = layui.$;
		form.render()
        table.render({
            elem: '#fb-table'
            ,url: index_url
            ,cols: [[
                {checkbox: true, fixed: true}
                ,{field:'id',title:'ID', width:80, sort: true}
                ,{field:'payment_company_name',title:"{{ trans('payment_company.name') }}"}
                ,{field:'merchant_name',title:"{{ trans('merchant.name') }}"}
                ,{field:'phone',title:"{{ trans('merchant.label.phone') }}", width:150}
                ,{field:'address',title:"{{ trans('merchant.label.address') }}"}
                ,{field:'province',title:"{{ trans('merchant.label.province') }}", width:75}
                ,{field:'city',title:"{{ trans('merchant.label.city') }}", width:75}
                ,{field:'created_at',title:"{{ trans('app.created_at') }}",width:120}
                ,{field:'score',title:'操作', width:150, align: 'right',toolbar:'#barDemo'}
            ]]
            ,id: 'fb-table'
            ,page: true
            ,limit: 10
            ,height: 'full-200'
        });
        $(".push_provider").click(function(){
            var checkStatus = table.checkStatus('fb-table')
                    ,data = checkStatus.data;
            var data_id_obj = {};
            var i = 0;
            data.forEach(function(v){ data_id_obj[i] = v.id; i++});
            data.length == 0 ?
                    layer.msg('请选择要分发服务商的巡检单', {
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    })
                    :
                    layer.confirm('是否将已选择的巡检单分发服务商',{title:'提示'},function(index){
                        layer.close(index);
                        layer.open({
                            type: 1,
                            shade: false,
                            title: '服务商',
                            area: ['420px', '340px'], //宽高
                            content: $('.provider_content'),
                            btn: ['确定'],
                            yes: function(index){
                                var provider_id = $(".provider_content").find("input[name='provider_id']:checked").val()
                                if(provider_id){
                                    var load = layer.load();
                                    $.ajax({
                                        url : "{{ guard_url('order_push_provider') }}",
                                        data :  {'ids':data_id_obj,'provider_id':provider_id,'_token' : "{!! csrf_token() !!}"},
                                        type : 'POST',
                                        success : function (data) {
                                            layer.msg(data.msg);
                                            var nPage = $(".layui-laypage-curr em").eq(1).text();
                                            //执行重载
                                            table.reload('fb-table', {
                                                page: {
                                                    curr: nPage //重新从第 1 页开始
                                                }
                                            });
                                            layer.close(index);
                                            layer.close(load);
                                        },
                                        error : function (jqXHR, textStatus, errorThrown) {
                                            layer.close(load);
                                            layer.msg('服务器出错');
                                        }
                                    });
                                }else{
                                    layer.msg('请选择服务商');
                                }
                                //layer.close(index);

                            }
                        });
                    })  ;
        })

    });
</script>
{!! Theme::partial('order_common_handle_js') !!}