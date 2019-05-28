<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>{{ trans('payment_company.name') }}详情</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('payment_company/'.$payment_company->id)}}" method="post" method="post" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('payment_company.label.name') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" autocomplete="off" placeholder="请输入{{ trans('payment_company.label.name') }}" class="layui-input" value="{{ $payment_company->name }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('payment_company.label.linkman') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="linkman" autocomplete="off" placeholder="请输入{{ trans('payment_company.label.linkman') }}" class="layui-input" value="{{ $payment_company->linkman }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('payment_company.label.phone') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="phone" autocomplete="off" placeholder="请输入{{ trans('payment_company.label.phone') }}" class="layui-input" value="{{ $payment_company->phone }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('payment_company.label.address') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="address" autocomplete="off" placeholder="请输入{{ trans('payment_company.label.address') }}" class="layui-input" value="{{ $payment_company->address }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('payment_company.label.service_tel') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="service_tel" autocomplete="off" placeholder="请输入{{ trans('payment_company.label.service_tel') }}" class="layui-input" value="{{ $payment_company->service_tel }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('payment_company.label.auth_file') }}</label>
                        {!! $payment_company->files('auth_file_path')->field('auth_file')
                        ->url($payment_company->getUploadUrl('auth_file_path'))
                        ->uploader()!!}
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
{!! Theme::asset()->container('ueditor')->scripts() !!}