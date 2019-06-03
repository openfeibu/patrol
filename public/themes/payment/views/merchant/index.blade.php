<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('merchant.name') }}管理</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            <div class="tabel-message">
                <div class="layui-inline tabel-btn">
                    <button class="layui-btn layui-btn-warm "><a href="{{guard_url('merchant/create')}}">添加{{ trans('merchant.name') }}</a></button>
                    <!--<button class="layui-btn layui-btn-normal create_order" data-type="create_order" data-events="create_order">批量发起巡检</button>
                    <button class="layui-btn layui-btn-normal create_order_no_record" data-type="create_order_no_record" data-events="create_order_no_record">全部未巡检商户发起巡检</button>-->
                    <button class="layui-btn layui-btn-primary " data-type="del" data-events="del">删除</button>
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
                        <input class="layui-input layui-input-inline search_key" name="search_name" id="demoReload" placeholder="商户名/商户号" autocomplete="off" value="{{ $search_name }}">
                    </div>
                    <button class="layui-btn mt10" data-type="reload">搜索</button>
                </div>
            </div>

            <table id="fb-table" class="layui-table"  lay-filter="fb-table">

            </table>
        </div>
    </div>
</div>

<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
</script>
<script type="text/html" id="imageTEM">
    <img src="@{{d.image}}" alt="" height="28">
</script>

<script>
    var main_url = "{{guard_url('merchant')}}";
    var delete_all_url = "{{guard_url('merchant/destroyAll')}}";
    layui.use(['jquery','element','table'], function(){
        var table = layui.table;
        var form = layui.form;
        var $ = layui.$;
        table.render({
            elem: '#fb-table'
            ,url: main_url
            ,cols: [[
                {checkbox: true, fixed: true}
                ,{field:'id',title:'ID', width:80, sort: true}
                ,{field:'name',title:"{{ trans('merchant.label.name') }}", width:200,edit:'text'}
                ,{field:'linkman',title:"{{ trans('merchant.label.linkman') }}",edit:'text'}
                ,{field:'phone',title:"{{ trans('merchant.label.phone') }}",edit:'text'}
                ,{field:'merchant_sn',title:"{{ trans('merchant.label.merchant_sn') }}",edit:'text'}
                ,{field:'model',title:"{{ trans('merchant.label.model') }}",edit:'text'}
                ,{field:'province',title:"{{ trans('merchant.label.province') }}",edit:'text'}
                ,{field:'city',title:"{{ trans('merchant.label.city') }}",edit:'text'}
                ,{field:'last_order_date',title:"上次巡检"}
                //,{field:'address',title:"{{ trans('merchant.label.address') }}",edit:'text'}
                ,{field:'score',title:'操作', width:150, align: 'right',toolbar:'#barDemo'}
            ]]
            ,id: 'fb-table'
            ,page: true
            ,limit: 10
            ,height: 'full-200'
        });
        table.on('tool(fb-table)', function(obj) {
            var data = obj.data;
            data['_token'] = "{!! csrf_token() !!}";

        });
        $(".create_order").click(function(){
            var checkStatus = table.checkStatus('fb-table')
                    ,data = checkStatus.data;
            var data_id_obj = {};
            var i = 0;
            data.forEach(function(v){ data_id_obj[i] = v.id; i++});
            data.length == 0 ?
                    layer.msg('请选择要发起巡检的商户', {
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    })
                    :
                    layer.confirm('是否已选择的商户发起巡检',{title:'提示'},function(index){
                        layer.close(index);
                        var load = layer.load();
                        $.ajax({
                            url : main_url + '/create_order',
                            data :  {'ids':data_id_obj,'_token' : "{!! csrf_token() !!}"},
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
                                layer.close(load);
                            },
                            error : function (jqXHR, textStatus, errorThrown) {
                                layer.close(load);
                                layer.msg('服务器出错');
                            }
                        });
                    })  ;
        });
        $(".create_order_no_record").click(function(){
            layer.confirm('是否全部未巡检商户发起巡检',{title:'提示'},function(index){
                layer.close(index);
                var load = layer.load();
                $.ajax({
                    url : main_url + '/create_order_no_record',
                    data :  {'_token' : "{!! csrf_token() !!}"},
                    type : 'POST',
                    success : function (data) {
                        layer.msg(data.msg);
                        if(data.code != 400)
                        {
                            var nPage = $(".layui-laypage-curr em").eq(1).text();
                            //执行重载
                            table.reload('fb-table', {
                                page: {
                                    curr: nPage //重新从第 1 页开始
                                }
                            });
                        }
                        layer.close(load);
                    },
                    error : function (jqXHR, textStatus, errorThrown) {
                        layer.close(load);
                        layer.msg('服务器出错');
                    }
                });
            })  ;
        })
    });
</script>
{!! Theme::partial('common_handle_js') !!}