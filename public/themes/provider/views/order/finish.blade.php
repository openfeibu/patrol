<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('order.name') }}管理</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            <div class="tabel-message order_search layui-form">
                <div class="layui-form-item">
                    @include('order.order_search')
                </div>
            </div>

            <table id="fb-table" class="layui-table"  lay-filter="fb-table">

            </table>
        </div>
    </div>
</div>

<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-sm" lay-event="edit">查看详情</a>
    <a class="layui-btn layui-btn-normal layui-btn-sm" lay-event="remark">备注</a>
	<a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="return">退回</a>
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
            ,url: "{{ guard_url('order_finish') }}"
            ,cols: [[
                {checkbox: true, fixed: true}
                ,{field:'id',title:'ID', width:80, sort: true}
                ,{field:'payment_company_name',title:"{{ trans('payment_company.name') }}"}
                ,{field:'merchant_name',title:"{{ trans('merchant.name') }}"}
                ,{field:'phone',title:"{{ trans('merchant.label.phone') }}",width:150}
                ,{field:'address',title:"{{ trans('merchant.label.address') }}"}
                ,{field:'province',title:"{{ trans('merchant.label.province') }}", width:75}
                ,{field:'city',title:"{{ trans('merchant.label.city') }}", width:75}
                ,{field:'user_name',title:"{{ trans('user.name') }}", width:80}
                ,{field:'created_at',title:"{{ trans('app.created_at') }}",width:120}
                ,{field:'score',title:'操作', width:220, align: 'right',toolbar:'#barDemo'}
            ]]
            ,id: 'fb-table'
            ,page: true
            ,limit: 10
            ,height: 'full-200'
        });

    });
</script>
{!! Theme::partial('order_common_handle_js') !!}
