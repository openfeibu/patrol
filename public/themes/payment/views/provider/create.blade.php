<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>添加{{ trans('provider.name') }}</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('provider')}}" method="post" method="post" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('provider.label.name') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" autocomplete="off" placeholder="请输入{{ trans('provider.label.name') }}" class="layui-input" value="">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('provider.label.linkman') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="linkman" autocomplete="off" placeholder="请输入{{ trans('provider.label.linkman') }}" class="layui-input" value="">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('provider.label.phone') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="phone" autocomplete="off" placeholder="请输入{{ trans('provider.label.phone') }}" class="layui-input" value="">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('provider.label.wechat') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="wechat" autocomplete="off" placeholder="请输入{{ trans('provider.label.wechat') }}" class="layui-input" value="">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                        </div>
                    </div>
                    {!!Form::token()!!}
                </form>
            </div>

        </div>
    </div>
</div>
{!! Theme::asset()->container('ueditor')->scripts() !!}