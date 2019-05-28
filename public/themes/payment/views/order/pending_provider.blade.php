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
                <div class="layui-inline tabel-btn">
                    <button class="layui-btn layui-btn-warm push_provider" data-type="push_provider" data-events="push_provider">批量分发服务商</button>
                    <button class="layui-btn layui-btn-primary " data-type="del" data-events="del">删除</button>
                </div>
            </div>

            <table id="fb-table" class="layui-table"  lay-filter="fb-table">

            </table>
        </div>
    </div>
</div>

<div class="provider_content">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <div class="layui-input-inline">
                @foreach($providers as $key => $provider)
                    <input type="radio" name="provider_id" value="{{ $provider->id }}" title="{{ $provider->name }}">
                @endforeach
            </div>
        </div>
    </form>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-sm" lay-event="edit">查看详情</a>
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
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
            ,url: "{{guard_url('order_pending_provider')}}"
            ,cols: [[
                {checkbox: true, fixed: true}
                ,{field:'id',title:'ID', width:80, sort: true}
                ,{field:'merchant_name',title:"{{ trans('merchant.name') }}"}
                ,{field:'provider_name',title:"{{ trans('provider.name') }}"}
                ,{field:'user_name',title:"{{ trans('user.name') }}"}
                ,{field:'status_desc',title:"{{ trans('order.label.status') }}"}
                ,{field:'created_at',title:"{{ trans('app.created_at') }}"}
                ,{field:'score',title:'操作', width:200, align: 'right',toolbar:'#barDemo'}
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
                            area: ['420px', '240px'], //宽高
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