<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('merchant.name') }}管理</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="tabel-message">
                <form class="form-horizontal" method="POST" action="{{ guard_url('merchant_submit_import') }}" enctype="multipart/form-data"  id="merchant_submit_import_form">
                    <div class="tabel-btn">
                        <button class="layui-btn layui-btn-warm "><a href="{{url('image/original/system/merchant/merchant_muban.xlsx')}}">下载模板</a></button>
                    </div>
                    <div class=" tabel-btn mt20">
                        {{ csrf_field() }}
                       
						<div class="input-file" >
							选择文件
							<input id="file" type="file" class="form-control" name="file" required>
						</div>
                         <label class="fileText">未选中文件</label>
                        <button type="button" class="layui-btn layui-btn-normal merchant_submit_import_btn">确定</button>
                        <span class="layui-word-aux">（注意：请严格按照模板格式；提交后将直接录入数据库，请谨慎操作！）</span>
                    </div>

                </form>
            </div>
            @if(isset($excel_data))
                <div class="" style="margin-top:10px;">
                    <form class="form-horizontal" method="POST" action="{{ guard_url('merchant_submit_import_data') }}" enctype="multipart/form-data" id="merchant_submit_import_data_form">

                        <div class="layui-inline tabel-btn">
                            <button class="layui-btn layui-btn-warm submit_btn" type="button">提交</button>
                        </div>
                        <table id="fb-table" class="layui-table"  >

                            <thead>
                            <tr>
                                <th>机型</th>
                                <th>商户号</th>
                                <th>PN</th>
                                <th>SN</th>
                                <th>全称</th>
                                <th>经营地址</th>
                                <th>联系人</th>
                                <th>联系电话</th>
                                <th>所属省</th>
                                <th>所属市</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($excel_data as $key => $data)
                                <tr>
                                    <td><input type="text" name="model[]" value="{{ $data['model'] }}" class="layui-input"></td>
                                    <td><input type="text" name="merchant_sn[]" value="{{ $data['merchant_sn'] }}" class="layui-input"></td>
                                    <td><input type="text" name="pn[]" value="{{ $data['pn'] }}" class="layui-input"></td>
                                    <td><input type="text" name="sn[]" value="{{ $data['sn'] }}" class="layui-input"></td>
                                    <td><input type="text" name="name[]" value="{{ $data['name'] }}" class="layui-input"></td>
                                    <td><input type="text" name="address[]" value="{{ $data['address'] }}" class="layui-input"></td>
                                    <td><input type="text" name="linkman[]" value="{{ $data['linkman'] }}" class="layui-input"></td>
                                    <td><input type="text" name="phone[]" value="{{ $data['phone'] }}" class="layui-input"></td>
                                    <td><input type="text" name="province[]" value="{{ $data['province'] }}" class="layui-input"></td>
                                    <td><input type="text" name="city[]" value="{{ $data['city'] }}" class="layui-input"></td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        <div class="layui-inline tabel-btn">
                            <button class="layui-btn layui-btn-warm submit_btn" type="button">提交</button>
                        </div>
                        {{ csrf_field() }}
                    </form>
                </div>
            @endif

        </div>
    </div>
</div>



<script>

    layui.use(['jquery','element','table'], function(){
        var table = layui.table;
        var form = layui.form;
        var $ = layui.$;
        $(".merchant_submit_import_btn").click(function(){
            var fileFlag = false;

            $("input[name='file']").each(function(){
                if($(this).val()!="") {
                    fileFlag = true;
                }
            });
            if(!fileFlag) {
                layer.msg("请选择文件");
                return false;
            }

            layer.msg('上传中', {
                icon: 16
                ,shade: 0.01
                ,time:0
            });
            $("#merchant_submit_import_form").submit();
        });
        $(".submit_btn").click(function(){
            layer.confirm('确认无误提交？',{title:'提示'},function(index) {
                layer.close(index);
                var load = layer.load();
                var data = $("#merchant_submit_import_data_form").serialize();
                $.ajax({
                    url : "{{ guard_url('merchant_submit_import_data') }}",
                    data :  data,
                    type : 'POST',
                    success : function (data) {
                        layer.close(load);
                        layer.msg(data.msg);
                        if(data.code == 200 || data.code == 0)
                        {
                            window.location.href = "{{guard_url('merchant')}}";
                        }
                    },
                    error : function (jqXHR, textStatus, errorThrown) {
                        layer.close(load);
                        layer.msg('服务器出错');
                    }
                });
            })
        })
		$(".input-file input").on('change', function( e ){
				//e.currentTarget.files 是一个数组，如果支持多个文件，则需要遍历
				var name = e.currentTarget.files[0].name;
				$(".fileText").text(name)
			});
    });
	
</script>
