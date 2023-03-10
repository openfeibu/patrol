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
                    <div class="layui-inline tabel-btn">
                        <button class="layui-btn layui-btn-primary " data-type="del" data-events="del">删除</button>
						<button class="layui-btn layui-btn-normal export-order-pdf">
						  <i class="layui-icon">&#xe601;</i> 导出巡检单
						</button>
                    </div>
                    @include('order.order_search')
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
                <input type="checkbox" name="provider_id" value="{{ $provider->id }}" title="{{ $provider->name }}">
            @endforeach
        </div>
    </form>
</div>
<div class="fields_content layui_open_content" style="display:none;">
    <form class="layui-form">
        <div class="layui-form-item">
            @foreach(config('model.order.order_record.excel_fields') as $key => $field)
                <input type="checkbox" name="fields[]" value="{{ $field }}" title="{{ trans('order_record.label.'.$field)  }}">
            @endforeach
        </div>
    </form>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-sm" lay-event="edit">详情</a>
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="return">退回</a>
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
</script>
<script type="text/html" id="imageTEM">
    <img src="@{{d.image}}" alt="" height="28">
</script>

<script>
    var main_url = "{{guard_url('order')}}";
    var delete_all_url = "{{guard_url('order/destroyAll')}}";
    var index_url = "{{ guard_url('order_pass') }}";
    layui.use(['jquery','element','table'], function(){
        var table = layui.table;
        var form = layui.form;
        var $ = layui.$;
        table.render({
            elem: '#fb-table'
            ,url: index_url
            ,cols: [[
                {checkbox: true, fixed: true}
                ,{field:'merchant_name',title:"{{ trans('merchant.name') }}"}
                ,{field:'phone',title:"{{ trans('merchant.label.phone') }}",width:150}
                ,{field:'address',title:"{{ trans('merchant.label.address') }}"}
                ,{field:'province',title:"{{ trans('merchant.label.province') }}", width:75}
                ,{field:'city',title:"{{ trans('merchant.label.city') }}", width:75}
                ,{field:'provider_name',title:"{{ trans('provider.name') }}", width:80}
                ,{field:'user_name',title:"{{ trans('user.name') }}", width:80}
                ,{field:'created_at',title:"{{ trans('app.created_at') }}",width:120}
                ,{field:'score',title:'操作', width:200, align: 'right',toolbar:'#barDemo'}
            ]]
            ,id: 'fb-table'
            ,page: true
            ,limit: 10
            ,height: 'full-200'
        });
		$(".export-order").on("click",function(){
	
                        layer.open({
                            type: 1,
                            shade: false,
                            title: '选择进行处理的字段',
                            area: ['420px', '340px'], //宽高
                            content: $('.fields_content'),
                            btn: ['脱敏处理','隐藏处理'],
                            yes: function(index){
                                var url = "{{ guard_url('export_order') }}?_token={!! csrf_token() !!}&type=encrypt"
                                $(".search_key").each(function(){
                                    var name = $(this).attr('name');
                                    url += "&search["+name+"]="+$(this).val();
                                });
                                $("input[name='fields[]']:checked").each(function(){
                                    url += "&fields[]="+$(this).val();
                                });
                                var load =layer.load();
                                window.location.href = url;

                                console.log(url);
                                layer.close(load);
                                layer.close(index);

                            },btn2: function(index, layero){
                                var url = "{{ guard_url('export_order') }}?_token={!! csrf_token() !!}&type=hidden"
                                $(".search_key").each(function(){
                                    var name = $(this).attr('name');
                                    url += "&search["+name+"]="+$(this).val();
                                });
                                $("input[name='fields[]']:checked").each(function(){
                                    url += "&fields[]="+$(this).val();
                                });
                                var load =layer.load();
                                window.location.href = url;

                                console.log(url);
                                layer.close(load);
                                layer.close(index);
                            }
                        });
                
		})
        $(".export-order-pdf").on("click",function(){
            var checkStatus = table.checkStatus('fb-table')
                    ,data = checkStatus.data;
            var data_id_obj = {};
            var i = 0;
            var url = "{{ guard_url('export_order_pdf') }}?_token={!! csrf_token() !!}"

            var load =layer.load();
            var form = $("<form method='post' target='_blank'></form>");
            var input;
            form.attr({"action":url});
            data.forEach(function(v){
                data_id_obj[i] = v.id; i++
                // url += '&ids[]='+v.id;
                input = $("<input type='hidden'>");
                input.attr({"name":"ids[]"});
                input.val(v.id);
                form.append(input);
            });
//            $.each(params,function (key,value) {
//                input = $("<input type='hidden'>");
//                input.attr({"name":key});
//                input.val(value);
//                form.append(input);
//            });
            $(document.body).append(form);
            form.submit();

            layer.close(load);
        })
    });
</script>
{!! Theme::partial('order_common_handle_js') !!}