<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans("payment_user.name") }}</cite></a><span lay-separator="">/</span>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('payment_user/'.$payment_user->id)}}" method="post" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans("payment_user.name") }}</label>
                        <div class="layui-input-inline">
                            <select name="payment_company_id">
                                @foreach($payment_companies as $key => $payment_company)
                                    <option value="{{ $payment_company->id }}" @if($payment_company->id == $payment_user->payment_company_id) selected @endif disabled>{{ $payment_company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans("payment_user.label.phone") }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="phone" value="{{ $payment_user->phone }}" lay-verify="required" autocomplete="off" placeholder="请输入{{ trans("payment_user.label.phone") }}" class="layui-input" disabled>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans("payment_user.label.name") }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" value="{{ $payment_user->name }}" lay-verify="required" autocomplete="off" placeholder="请输入{{ trans("payment_user.label.name") }}" class="layui-input" >
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans("payment_user.label.new_password") }}</label>
                        <div class="layui-input-inline">
                            <input type="password" name="password" placeholder="请输入{{ trans("payment_user.label.password") }}，不改则留空" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">请输入密码，不改则留空</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans("payment_user.label.roles") }}</label>
                        <div class="layui-input-block">
                            @foreach($roles as $key => $role)
                            <input type="radio" name="roles[]" value="{{ $role->id }}" title="{{ $role->name }}" {{ !($payment_user->hasRole($role->slug)) ? :'checked'}}>
                            @endforeach
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                        </div>
                    </div>
                    {!!Form::token()!!}
                    <input type="hidden" name="_method" value="PUT">
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    layui.use('form', function(){
        var form = layui.form;

        form.render();
    });
</script>

