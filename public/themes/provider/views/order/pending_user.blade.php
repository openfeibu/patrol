<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('order.name') }}管理</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            <div class="tabel-message order_search">
                <div class="layui-form-item">
                    <div class="layui-inline tabel-btn">
                        <button class="layui-btn layui-btn-warm push_user" data-type="push_user" data-events="push_user">批量分发巡检员</button>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">{{ trans("payment_company.name") }}：</label>
                        <select name="payment_company_id" class="search_key layui-select" lay-verify="">
                            <option value="0">全部</option>
                            @foreach($payment_companies as $key => $payment_company)
                                <option value="{{ $payment_company->id }}" @if($payment_company->id == $payment_company_id) selected @endif>{{ $payment_company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @include('order.order_search')
                </div>
            </div>

            <table id="fb-table" class="layui-table"  lay-filter="fb-table">

            </table>
        </div>
    </div>
</div>
<div class="user_content">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <div class="layui-input-inline">
                @foreach($users as $key => $user)
                    <input type="radio" name="user_id" value="{{ $user->id }}" title="{{ $user->name }}({{ $user->phone }})">
                @endforeach
            </div>
        </div>
    </form>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-sm" lay-event="edit">查看详情</a>
</script>
<script type="text/html" id="imageTEM">
    <img src="@{{d.image}}" alt="" height="28">
</script>

<script>
    var main_url = "{{guard_url('order')}}";
    var delete_all_url = "{{guard_url('order/destroyAll')}}";
    layui.use(['jquery','element','table'], function(){
        var table = layui.table;
        var form = layui.form;
        var $ = layui.$;
        table.render({
            elem: '#fb-table'
            ,url: "{{ guard_url('order_pending_user') }}"
            ,cols: [[
                {checkbox: true, fixed: true}
                ,{field:'payment_company_name',title:"{{ trans('payment_company.name') }}"}
                ,{field:'merchant_name',title:"{{ trans('merchant.name') }}"}
                ,{field:'phone',title:"{{ trans('merchant.label.phone') }}",width:150}
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
        $(".push_user").click(function(){
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
                    layer.confirm('是否将已选择的巡检单分发巡检员？',{title:'提示'},function(index){
                        layer.close(index);
                        layer.open({
                            type: 1,
                            shade: false,
                            title: '服务商',
                            area: ['420px', '240px'], //宽高
                            content: $('.user_content'),
                            btn: ['确定'],
                            yes: function(index){
                                var user_id = $(".user_content").find("input[name='user_id']:checked").val()
                                if(user_id){
                                    var load = layer.load();
                                    $.ajax({
                                        url : "{{ guard_url('order_push_user') }}",
                                        data :  {'ids':data_id_obj,'user_id':user_id,'_token' : "{!! csrf_token() !!}"},
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